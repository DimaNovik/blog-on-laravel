<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;

class DashboardController extends Controller
{
    public function index() {

//        $users = User::where('id','>=','414')->get();
//        foreach ($users as $user) {
//
//            $user->generatePassword($user->password);
//
//        }


        return view('admin.dashboard');
    }
}
