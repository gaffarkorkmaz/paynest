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

class ApiPaymentController extends Controller
{

    public function createpayment(Request $request)
    {
        /*
         * secretKey
         * tutar
         * shopId - ürünün benzersiz idsi, callbacke iletilecek
         * metod - hangi postan geçecek
         * musteriAd
         * musteriSoyad
         * musteriEposta
         * musteriTelefon
         * musteriAdres
         * musteriTckn - zorunlu değil
         * musteriIp
         * basariliUrl
         * basarisizUrl
         * callbackUrl
         * urunAdi
         * urunAdet
         * urunFiyat
         *
         * dönüşte ödeme linki olacak
         *
         *
         */

        $request->validate([
            'secretKey' => 'required',
            'shopId' => 'required|integer',
            'tutar' => 'required|integer',
            'metod' => 'required',
            'musteriAd' => 'required',
            'musteriSoyad' => 'required',
            'musteriTelefon' => 'required',
            'musteriEposta' => 'required',
            'musteriAdres' => 'required',
            'musteriIp' => 'required',
            'basariliUrl' => 'required',
            'basarisizUrl' => 'required',
            'callbackUrl' => 'required',
            'urunAdi' => 'required',
            'urunAdet' => 'required',
            'urunFiyat' => 'required',
        ]);

        $secretKey = $request->input('secretKey');

        $pos = DB::table("pos_keys")->where('secret_key', $secretKey)->where("status", 1)->first();

        if ($pos) {

            $metod= $request->input('metod');

            $izinverilen=explode(",", $pos->permissions );

            $gateway = DB::table("gateways")->where("name", $metod)->first();

            if (!$gateway) {
                return json_encode(["status" => "error", "message" => "Geçersiz ödeme metodu."]);
            }

            if (!in_array($gateway->name, $izinverilen)) {
                return json_encode(["status" => "error", "message" => "Bu anahtar için seçilen ödeme metoduna erişim izni yok."]);
            }

            if (!method_exists($this, $metod)) {
                return json_encode(["status" => "error", "message" => "Bu ödeme metodu henüz desteklenmiyor."]);
            }


            // Ayrı tabloya detayları kaydedilsin
            // ve fatura işlemleri yapılsın
            // sonra fatura posundan ayrı olarak ödeme işlemi başlayacak
            // ama callback tek bir yerde olacak

            // email ile müşteri yoksa müşteri ve faturası oluşturulacak
            // müşteri varsa sadece faturea


            // fatura oluşumu


            // tüm müşteri ve fatura oluşturma başarılı içinde olmalı
            // edit: başarılı dışına alındı çünkü paytr ile fatura id iletmek zorundayız
            // çünkü callback fatura id ile çalışıyor tek yerde halletmek için fatura id zorunlu
            // eğer paytr hata verirse mecbur fatura da oluşacak müşteri de silme işlemi yapılmayacak

            $eposta=$request->input('musteriEposta');

            $musteri=DB::table("customers")->where('email', $eposta)->first();

            if ($musteri) {
                // müşteri var silinmişse deleted 0 yapalım

                $musteriId=$musteri->id;
                DB::table('customers')->where('id', $musteriId)->update(['deleted' => 0]);

            }else{
                // müşteri yok oluşturalım

                $musteriId = DB::table('customers')->insertGetId([
                    'name'          => $request->input('musteriAd'),
                    'surname'       => $request->input('musteriSoyad'),
                    'idn'           => $request->input('musteriTckn', "11111111111"),
                    'email'         => $request->input('musteriEposta'),
                    'phone'         => $request->input('musteriTelefon'),
                    'address'       => $request->input('musteriAdres'),
                    'customer_type' => 1,
                    'deleted'       => 0,
                    'notes'         => "Sanal pos ödemesi için oluşturulmuştur."
                ]);

            }


            $olusturulanbody = '[{"name":"'.$request->input('urunAdi').'","quantity":"'.$request->input('urunAdet').'","price":"'.$request->input('urunFiyat').'","total":"'.$request->input('urunAdet')*$request->input('urunFiyat').'"}]';
            $faturaId = DB::table('invoices')->insertGetId([
                'invoiceid'     => rand(0,9999999),
                'type' => 'pos',
                'external_id' => 0,
                'cid' => $musteriId,
                'body' => $olusturulanbody,
                'note' => $pos->name." için oluşturulmuş pos ödemesinin faturasıdır.",
                'status' => 0,
                'total' => $request->input('tutar'),
                'tax_rate' => 0,
                'created_time' => time(),
                'ip' => $request->input('musteriIp'),
                'method' => $metod
            ]);

            $sonuc=$this->$metod($request,$faturaId);

            if ($sonuc["status"] == "success") {
                $odeme_link=$sonuc['link'];

                $posticerigi = $request->post();
                $json = json_encode($posticerigi, JSON_UNESCAPED_UNICODE);
                $eklenenId = DB::table('pos_request')->insertGetId([
                    'invoiceid'  => $faturaId,
                    'key_id'     => $pos->id,
                    'time'       => time(),
                    'ip'         => $request->ip(),
                    'body'       => $json,
                    'response'   => 'Ödeme linki oluşturulmuştur.',
                    'method'     => $metod,
                    'cid'        => $musteriId,
                    'odeme_link' => $odeme_link,
                    'tur'        => $sonuc['tur'],
                    'iframesrc'  => $sonuc['iframesrc']
                ]);

                DB::update("update invoices set external_id = $eklenenId where id = $faturaId");

                return json_encode(["status" => "success", "odeme_url" => $odeme_link , "message" => "Ödeme başarıyla oluşturuldu."]);
            }else{
                $hata=$sonuc['hata'];
                return json_encode(["status" => "error", "message" => $hata]);
            }


        }else{
            return json_encode(["status" => "error", "message" => "Secret key bulunamadı veya aktif değil."]);
        }

    }

    public function iframePayment($gateway, $id)
    {
        // iframe ödeme yeri, zorunlu site içi gerekiyorsa iframe kullanılacak
        // örn paytr iframe de sadece siteye izin verilen domainde izin veriyor
        $fatura=DB::table('invoices')->where('id', $id)->first();
        $pos_request=DB::table('pos_request')->where('id', $fatura->external_id)->first();

        if ($pos_request->tur != "iframe") {
            // ödeme türü iframe değilmiş
            abort(404);
        }

        return view('api_payment', compact('gateway', 'pos_request'));
    }

    public function basarili($id)
    {
        $fatura=DB::table('invoices')->where('id', $id)->first();
        $pos_request=DB::table('pos_request')->where('id', $fatura->external_id)->first();

        $body=json_decode($pos_request->body, true);
        if ($pos_request->yonlendirme) {
            // zaten yönlendirme yapılmış ziyaret eden başkası olabilir 404 ver
            abort(404);
        }else{
            // yönlendirme daha önce yapılmamış müşteri ziyaret yönlendirme yapalım
            $basariliUrl=$body['basariliUrl'];

            DB::table('pos_request')->where('id', $fatura->external_id)->update(['yonlendirme' => 1]);
            return redirect($basariliUrl);
        }

    }

    public function basarisiz($id)
    {
        $fatura=DB::table('invoices')->where('id', $id)->first();
        $pos_request=DB::table('pos_request')->where('id', $fatura->external_id)->first();

        $body=json_decode($pos_request->body, true);
        if ($pos_request->yonlendirme) {
            // zaten yönlendirme yapılmış ziyaret eden başkası olabilir 404 ver
            abort(404);
        }else{
            // yönlendirme daha önce yapılmamış müşteri ziyaret yönlendirme yapalım
            $basarisizUrl=$body['basarisizUrl'];

            DB::table('pos_request')->where('id', $fatura->external_id)->update(['yonlendirme' => 1]);
            return redirect($basarisizUrl);
        }
    }


    public function paytr(Request $request,$randomid)
    {
        // paytr işlemleri yapılıp return yapılacak, 2 tur var iframe ve redirect, redirect olursa direkt ödeme linki
        // iframe olursa site içinde iframe kullanacağımız link olacak
        // paytr için site içi iframe lazım
        // paytr direkt yönlendirmeye izin vermiyor

        $method=DB::table('gateways')->where('name','paytr')->where('status', 1)->first();
        $anahtar=json_decode($method->credentials, true);

        $merchantId=$anahtar['merchantId'];
        $merchantKey=$anahtar['merchantKey'];
        $merchantSalt=$anahtar['merchantSalt'];

        $merchant_id    = $merchantId;
        $merchant_key   = $merchantKey;
        $merchant_salt  = $merchantSalt;

        $email = $request->input('musteriEposta');
        $payment_amount = $request->input('tutar')*100;

        // kendi idimiz
        $merchant_oid = $randomid;
        $user_name = $request->input('musteriAd')." ".$request->input('musteriSoyad');
        $user_address = $request->input('musteriAdres');
        $user_phone = $request->input('musteriTelefon');


        // paravan siteyi çaktırmamak için başarılı url kendi urlmiz olacak
        // 1 kere yönlendirmeden sonra bir daha yönlendirma yapılmasın paravan site belli olmasın
        $merchant_ok_url = url('odeme/basarili/'.$randomid);
        $merchant_fail_url = url('odeme/basarisiz/'.$randomid);

        $user_basket = base64_encode(json_encode(array(
            array($request->input('urunAdi'), $request->input('urunFiyat'), $request->input('urunAdet')),
        )));

        $user_ip=$request->input('musteriIp');

        $timeout_limit = "30";
        $debug_on = 1;
        $test_mode = 0;
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
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $result = @curl_exec($ch);

        if(curl_errno($ch)) {
            die("PAYTR IFRAME connection error. err:" . curl_error($ch));
        }

        curl_close($ch);

        $result=json_decode($result,1);

        if($result['status']=='success') {
            $token = $result['token'];

            $tur="iframe";
            $link=url('paytr/odeme/'.$randomid);
            $iframesrc="https://www.paytr.com/odeme/guvenli/".$token;

            return array("status"=>"success","link"=>$link,"iframesrc"=>$iframesrc,"tur"=>$tur);
        }else{
            return array("status"=>"error","hata"=>$result["reason"]);
        }
    }



}
