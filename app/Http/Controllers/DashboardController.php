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

class DashboardController extends Controller
{

    public function index()
    {

        $faturalar = DB::table("invoices")->orderBy('id', 'DESC')->limit(20)->get();
        $toplamfaturasayisi = $faturalar->count();
        $odenenfaturasayisi = DB::table("invoices")->where("status", "1")->get()->count();
        $bekleyenfaturasayisi = DB::table("invoices")->where("status", "0")->get()->count();


        $musteriler = DB::table("customers")->where('deleted', 0)->limit(20)->get();


        $faturageliri = DB::table('invoices')->where('status', '1')->sum('total');

        $products=DB::table("products")->where('deleted', 0)->get();

        $gelir = $faturageliri;

        return view("dashboard", compact("faturalar", "products", "toplamfaturasayisi", "odenenfaturasayisi", "bekleyenfaturasayisi", "gelir", "musteriler"));
    }


}
