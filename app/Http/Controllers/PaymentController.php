<?php
/*
***********************************************************
Adı Soyadı: Gaffar Korkmaz
Öğrenci Numarası: 262484021
***********************************************************
*/
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{

    //FATURA ÖDEME İSTEĞİ
    public function payment(Request $request)
    {
        $secilen=$request->input('payment_method');

        $method=DB::table('gateways')->where('name',$secilen)->where('status', 1)->first();

        if (!$method) {
            return redirect()->back()->with("error", "Bilinmeyen veya devre dışı method.");
        }

        $fatura=DB::table('invoices')->where('id',$request->input('invoice_id'))->first();

        if (!$fatura) {
            return redirect()->back()->with("error", "Bilinmeyen fatura.");
        }

        $musteri=DB::table('customers')->where('id',$fatura->cid)->first();

        if (!$musteri) {
            return redirect()->back()->with("error", "Bilinmeyen bir hata oluştu. Lütfen site yöneticisi ile iletişime geçin.");
        }

        $anahtar=json_decode($method->credentials, true);

        if ($method->name == "paytr") {
            // PAYTR ÖDEME BAŞLATMA
            $merchantId=$anahtar['merchantId'];
            $merchantKey=$anahtar['merchantKey'];
            $merchantSalt=$anahtar['merchantSalt'];

            if ($anahtar['testMode'] == 1) {
                $test_mode = 1;
            }else{
                $test_mode = 0;
            }


            $merchant_id    = $merchantId;
            $merchant_key   = $merchantKey;
            $merchant_salt  = $merchantSalt;

            $email = $musteri->email;
            $kdvtutar=(($fatura->total*$fatura->tax_rate)/100);
            $toplam=$fatura->total+$kdvtutar;

            $payment_amount = $toplam*100;
            $merchant_oid = $fatura->id;
            $user_name = $musteri->name." ".$musteri->surname;
            $user_address = $musteri->address;
            $user_phone = $musteri->phone;
            $merchant_ok_url = route('fatura.show', [$fatura->id, $fatura->invoiceid]);
            $merchant_fail_url = route('fatura.show', [$fatura->id, $fatura->invoiceid]);

            $icerik=[];

            $body=json_decode($fatura->body, true);

            foreach ($body as $basket) {
                $icerik[]=[$basket['name'], $basket['price'], $basket['quantity']];
            }

            $user_basket = base64_encode(json_encode($icerik));

            if( isset( $_SERVER["HTTP_CLIENT_IP"] ) ) {
                $ip = $_SERVER["HTTP_CLIENT_IP"];
            } elseif( isset( $_SERVER["HTTP_X_FORWARDED_FOR"] ) ) {
                $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
            } else {
                $ip = $_SERVER["REMOTE_ADDR"];
            }

            $user_ip=$ip;
            $timeout_limit = "30";
            $debug_on = 1;


            $no_installment = 0;
            $max_installment = 0;
            $currency = "TL";

            $hash_str = $merchant_id .$user_ip .$merchant_oid .$email .$payment_amount .$user_basket.$no_installment.$max_installment.$currency.$test_mode;
            $paytr_token=base64_encode(hash_hmac('sha256',$hash_str.$merchant_salt,$merchant_key,true));
            $post_vals=array(
                'merchant_id'=>$merchant_id,
                'user_ip'=>$user_ip,
                'merchant_oid'=>$merchant_oid,
                'email'=>$email,
                'payment_amount'=>$payment_amount,
                'paytr_token'=>$paytr_token,
                'user_basket'=>$user_basket,
                'debug_on'=>$debug_on,
                'no_installment'=>$no_installment,
                'max_installment'=>$max_installment,
                'user_name'=>$user_name,
                'user_address'=>$user_address,
                'user_phone'=>$user_phone,
                'merchant_ok_url'=>$merchant_ok_url,
                'merchant_fail_url'=>$merchant_fail_url,
                'timeout_limit'=>$timeout_limit,
                'currency'=>$currency,
                'test_mode'=>$test_mode
            );

            $ch=curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://www.paytr.com/odeme/api/get-token");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1) ;
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_vals);
            curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 20);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            $result = @curl_exec($ch);

            if(curl_errno($ch)) {
                return redirect()->back()->with("error", "PAYTR IFRAME connection error. err:" . curl_error($ch));
            }

            curl_close($ch);

            $result=json_decode($result,1);

            if($result['status']=='success') {
                $token = $result['token'];
            }else{
                return redirect()->back()->with("error", "Paytr Error:".$result["reason"]);
            }

            return view("paytr", compact("token"));
            // PAYTR SON
        }

    }

    //FATURA CALLBACK
    public function callback($gateway, Request $request)
    {
        $pos=DB::table("gateways")->where("name", $gateway)->where('status', 1)->first();
        $anahtar=json_decode($pos->credentials, true);
        if ($gateway == "paytr" and $pos) {
            // PAYTR FATURA CALLBACK
            $post = $_POST;

            $merchant_key   = $anahtar['merchantKey'];
            $merchant_salt  = $anahtar['merchantSalt'];

            $ip=$_SERVER['REMOTE_ADDR'];

            $hash = base64_encode( hash_hmac('sha256', $post['merchant_oid'].$merchant_salt.$post['status'].$post['total_amount'], $merchant_key, true) );
            if( $hash != $post['hash'] ) {
                die('PAYTR notification failed: bad hash');
            }

            $fatura=DB::table("invoices")->where("id", $post['merchant_oid'])->first();

            if( $post['status'] == 'success' ) {

                DB::update("update invoices set status = 1, ip='".$ip."', method='paytr', payed_time='".time()."' where id = '".$post['merchant_oid']."'");





                if($fatura->type == "urun"){
                    $urunid=$fatura->external_id;
                    DB::update("update products set stok = stok - 1  where id = '".$urunid."'");
                    $urun=DB::table("products")->where("id", $urunid)->first();

                    if ($urun->stok == 0) {
                        DB::update("update products set stok = -1  where id = '".$urunid."'");
                    }

                    echo "OK";

                }else if ($fatura->type == "pos"){
                    // callbacke istek atılacak
                    $pos_request=DB::table("pos_request")->where("id", $fatura->external_id)->first();
                    $key=DB::table("pos_keys")->where("id", $pos_request->key_id)->first();
                    $body=json_decode($pos_request->body, true);

                    $callback=$body['callbackUrl'];

                    $hash=hash("SHA256", $key->secret_key.$body['shopId'].$body['tutar'].$body['urunAdi'].$body['urunFiyat']);

                    $callbackData=array(
                        'shopId'=>$body['shopId'],
                        'tutar'=>$body['tutar'],
                        'urunAdi' => $body['urunAdi'],
                        'urunAdet' => $body['urunAdet'],
                        'urunFiyat' => $body['urunFiyat'],
                        'status' => "success",
                        'message' => "Ödeme başarılı.",
                        'hash' => $hash,
                    );

                    $response = Http::timeout(10)->post($callback, $callbackData);

                    $GelenCevap = $response->body();

                    if ($GelenCevap === 'OK') {

                        DB::table("pos_request")->where("id", $fatura->external_id)->update([
                            'callback_response' => $GelenCevap,
                            'callback_status' => "1",
                        ]);
                        echo "OK";
                    } else {
                        // siteden ok gelmedi bizde ok dönmeyeceğiz böylece bir daha callback geldiğinde
                        // diğer siteye yine callback ileteceğiz
                        DB::table("pos_request")->where("id", $fatura->external_id)->update([
                            'callback_response' => $GelenCevap,
                            'callback_status' => "0",
                        ]);

                        echo "FAIL";

                    }

                }else{

                    echo "OK";

                }

            }else{
                echo "OK";

            }


            exit;


        }else{
            abort(404);
        }

    }


}
