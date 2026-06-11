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
use Illuminate\Support\Facades\Storage;

class GeneralController extends Controller
{


    public function ayarlar()
    {
        $gateways = DB::table('gateways')->get();
        $user=Auth::user();

        return view('settings', compact('gateways', 'user'));
    }

    public function posayar(Request $request)
    {
        $request->validate([
            'provider' => 'required'
        ]);

        $gateways = DB::table('gateways')->where('name', $request->input('provider'))->get();

        if ($gateways->isEmpty()) {
            return redirect()->back()->with("error", "Ödeme geçidi bulunamadı.");
        } else {

            $credentials = json_decode($gateways[0]->credentials);
            $yeni = [];

            foreach ($credentials as $credential => $value) {
                if (!empty($request->input($credential))) {
                    $yeni[$credential] = $request->input($credential);
                } else {
                    $yeni[$credential] = $value;
                }

                if ($credential == "testMode" and empty($request->input($credential))) {
                    $yeni[$credential] = 0;
                }
            }

            $son = json_encode($yeni);

            $guncelle = DB::table('gateways')->where('name', $request->input('provider'))->update(['credentials' => $son]);

            if ($guncelle) {
                return redirect(route('ayarlar'));
            } else {
                return redirect()->back()->with("error", "Güncelleme yapılırken bir sorun oluştu.");
            }

        }
    }


    public function aktif($id){
        $guncelle = DB::table('gateways')->where('id', $id)->update(['status' => 1]);

        if ($guncelle) {
            return redirect(route('ayarlar'));
        }else{
            return redirect()->back();
        }
    }

    public function pasif($id){
        $guncelle = DB::table('gateways')->where('id', $id)->update(['status' => 0]);

        if ($guncelle) {
            return redirect(route('ayarlar'));
        }else{
            return redirect()->back();
        }
    }

    public function sirket_duzen(Request $request){
        $request->validate([
            'company_name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'email' => 'required',
            'site' => 'required',
        ]);

        $sirket = updateConfig("sirket", $request->input('company_name'));
        $adres  = updateConfig('adres', $request->input('address'));
        $tel    = updateConfig('telefon', $request->input('phone'));
        $email  = updateConfig('eposta', $request->input('email'));
        $site   = updateConfig('site', $request->input('site'));

        $resimYolu = getFunction('favicon');

        if ($request->hasFile('favicon')) {
            if ($resimYolu && file_exists(public_path($resimYolu))) {
                unlink(public_path('storage/'.$resimYolu));
            }
            $dosyaAdi = time() . '.' . $request->file('favicon')->getClientOriginalExtension();
            $request->file('favicon')->move(public_path('storage'), $dosyaAdi);
            $resimYolu =  $dosyaAdi;
        }

        updateConfig('favicon', $resimYolu);

        if ($sirket && $adres && $tel && $email) {
            return redirect(route('ayarlar'))->with('success', 'Ayarlar başarıyla güncellendi.');
        } else {
            return redirect()->back()->with("error", "Güncelleme yapılırken bir sorun oluştu.");
        }

    }

    public function profil_duzen(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
        ]);


        if (empty($request->input('new_password_confirm')) and empty($request->input('new_password')) and empty($request->input('current_password'))) {
            $guncelle=Auth::user()->update(['name' => $request->input('name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone')]);

            if ($guncelle) {
                return redirect(route('ayarlar'));
            }else{
                return redirect()->back()->with("error", "Değişiklikler kaydedilirken bir hata oluştu.");
            }

        }else{
            if (!empty($request->input('current_password'))) {

                if ($request->input('new_password_confirm') == $request->input('new_password')) {

                    $sifre=Auth::user()->update(['password' => bcrypt($request->input('new_password'))]);
                    $guncelle=Auth::user()->update(['name' => $request->input('name'),
                        'email' => $request->input('email'),
                        'phone' => $request->input('phone')]);


                    if ($sifre and $guncelle) {
                        return redirect(route('ayarlar'));
                    }else{
                        return redirect()->back()->with("error", "Değişiklikler kaydedilirken bir hata oluştu.");
                    }

                }else{
                    return redirect()->back()->with("error", "Yeni şifreniz ve şifre tekrarınız birbiri ile uyuşmuyor.");
                }

            }else{
                return redirect()->back()->with("error", "Şifrenizi değiştirmek için güncel şifrenizi giriniz.");
            }
        }



    }

}
