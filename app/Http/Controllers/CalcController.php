<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\cl_notary_actions;
use App\cl_notary_services;
use App\cl_notary_services_price;
use App\cl_notary_order;



class CalcController extends Controller
{
    public function index() {

        return view('pages.calculator');

    }


    public function actions() {
        return cl_notary_actions::all();
    }

    public function services($id) {
        return cl_notary_services::where('parent_id', $id)->get();
    }

    public function price($id) {
        return cl_notary_services_price::where('service_id', $id)->firstOrFail();
    }

    public function create(Request $request) {
        return cl_notary_order::create($request->all());
    }

    public function orders($id) {
        return cl_notary_order::where('user_id', $id)->get();
    }

}
