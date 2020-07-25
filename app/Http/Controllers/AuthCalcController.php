<?php

namespace App\Http\Controllers;
use App\cl_users;
use \Auth;
use Illuminate\Http\Request;


class AuthCalcController extends Controller
{
    //
    public function register(Request $request) {

        $this->validate($request, [
            'name' => 'required',
            'group_id' => 'required',
            'login' => 'required|unique:users',
            'password' => 'required',
        ]);


        $user = cl_users::add($request->all());
        $user->generatePassword($request->get('password'));

        return response()->json([
            'status' => 'ok'
        ]);
    }

    public function login(Request $request)
    {

        $this->validate($request, [
            'login' => 'required',
            'password' => 'required',
        ]);


        if(Auth::attempt([
            'login' => $request->get('login'),
            'password' => $request->get('password'),
        ])) {
            return response()->json([
                'status' => 'ok'
            ]);
        } else {
            return response()->json([
                'status' => 'error'
            ]);
        }
    }
}
