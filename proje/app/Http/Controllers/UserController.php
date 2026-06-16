<?php
/*
***********************************************************
Adı Soyadı: Gaffar Korkmaz
Öğrenci Numarası: 262484021
***********************************************************
*/
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{

    public function index()
    {
        return view("welcome");
    }

    public function login(Request $request)
    {
        $request->validate([
            "email" => "required|email",
            "password" => "required",
            "remember" => "nullable",
        ]);


        $user = User::where("email", $request->email)->first();

        if (!$user) {
            return redirect()->back()->with("error", "E-posta adresi veya şifre yanlış.");
        }

        if (!Hash::check($request->password, $user->password)) {
            return redirect()->back()->with("error", "E-posta adresi veya şifre yanlış.");
        }

        $remember = $request->has('remember') ? true : false;

        Auth::login($user, $remember);

        return redirect()->route("dashboard");
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route("login");
    }

}
