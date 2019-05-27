<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;

class DashboardController extends Controller
{
    public function index() {

//        $users = User::all();
//
//        foreach ($users as $user) {
//
//            $user->generatePassword($user->password);
//
//        }


        return view('admin.dashboard');
    }
}
