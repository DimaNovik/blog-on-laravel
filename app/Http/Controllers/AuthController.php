<?php

namespace App\Http\Controllers;

use App\User;
use \Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function registerForm() {
        return view('pages.register');
    }

    public function register(Request $request) {

        $this->validate($request, [
           'name' => 'required',
           'phone' => 'required',
           'email' => 'required|email|unique:users',
           'password' => 'required',
        ]);


        $user = User::add($request->all());
        $user->generatePassword($request->get('password'));

        return response()->json([
            'status' => 'ok'
        ]);
    }

    public function login(Request $request) {

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $result = Auth::attempt([
            'email' => $request->get('email'),
            'password' => $request->get('password'),
        ]);



        return response()->json([
            'status' => 'ok'
        ]);
    }

    public function logout() {
        Auth::logout();

        return redirect('/');
    }


}
