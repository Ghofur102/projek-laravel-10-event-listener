<?php

namespace App\Http\Controllers;

use App\Models\notifications;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthenticateControllers extends Controller
{
    public function login()
    {
        // for login page
        return view("auth.login");
    }
    public function sign_in(Request $request)
    {
        // for process login
        $rules = [
            "nameOrEmail" => "required",
            "password" => "required|min:8"
        ];
        $messages = [
            "nameOrEmail.required" => "Nama atau email tidak boleh kosong!",
            "password.required" => "Password tidak boleh kosong!",
            "password.min" => "Password tidak boleh kurang dari 8 karakter!"
        ];
        $validate = Validator::make($request->all(), $rules, $messages);
        if ($validate->fails()) {
            return redirect()->back()->with("error", $validate->errors()->first());
        }
        if (filter_var($request->nameOrEmail, FILTER_VALIDATE_EMAIL)) {
            $credentials = [
                "email" => $request->nameOrEmail,
                "password" => $request->password
            ];
        } else {
            $credentials = [
                "name" => $request->nameOrEmail,
                "password" => $request->password
            ];
        }
        if (Auth::attempt($credentials)) {
            return redirect('/');
        } else {
            return redirect()->back()->with("error", "Anda belum punya akun!");
        }
    }
    public function register()
    {
        // for register page
        return view("auth.register");
    }
    public function sign_up(Request $request)
    {
        // for process register
        $rules = [
            "name" => "required",
            "email" => "required|email",
            "password" => "required|min:8",
            "biodata" => "required|max:2500"
        ];
        $messages = [
            "name.required" => "Nama tidak boleh kosong!",
            "email.required" => "Email tidak boleh kosong!",
            "email.email" => "Format email yang anda kirim, salah!",
            "password.required" => "Password tidak boleh kosong!",
            "password.min" => "Password minimal berisi 8 karakter!",
            "biodata.required" => "Biodata harus diisi!",
            "biodata.max" => "Biodata tidak boleh lebih dari 2.500 karakter",
        ];
        $validate = Validator::make($request->all(), $rules, $messages);
        if ($validate->fails()) {
            return redirect()->back()->with("error", $validate->errors()->first());
        }
        $create_new_user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => bcrypt($request->password),
            "biodata" => $request->biodata
        ]);
        if ($create_new_user) {
            return redirect('/login');
        } else {
            return redirect()->back()->with("error", "Proses register gagal!");
        }
    }
    public function logout()
    {
        // for logout process
        Auth::logout();
        return redirect('/login')->with("success", "Anda berhasil logout!");
    }
    public function home()
    {
        $allUsers = User::all();
        $notifications = notifications::where("user_id", Auth::user()->id)->where("isRead", null)->get();
        return view('welcome', compact("allUsers", "notifications"));
    }
}
