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

class PosController extends Controller
{

    public function index() {

        $gateways = DB::table('gateways')->get();
        $apiKeys = DB::table('pos_keys')->get();
        return view('pos', compact('gateways', 'apiKeys'));
    }


    public function apikey_store(Request $request) {
        $request->validate([
            "name" => "required",
            "status" => "required",
            "pos_access" => "required",
        ]);
        $permissions=implode(',', $request->input('pos_access', []));
        $secret_key=\Str::random(40);

        $ekle=DB::table('pos_keys')->insert(["secret_key" => $secret_key,"name" => $request->input('name'),"status" => $request->input('status'),"permissions" => $permissions, "time" => time()]);



        return redirect()->route('pos.ayarlar');
    }

    public function apikey_sil($id) {
        $sil=DB::table('pos_keys')->where("id",$id)->delete();
        return redirect()->route('pos.ayarlar');
    }

    public function apikey_kapat($id) {
        $eck = DB::table('pos_keys')->where("id", $id)->first();

        $yeniStatus = $eck->status == 1 ? 0 : 1;

        DB::table('pos_keys')->where("id", $id)->update(['status' => $yeniStatus]);

        return redirect()->route('pos.ayarlar');
    }

}
