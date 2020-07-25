<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\cl_notary_actions;
use App\cl_notary_services;
use App\cl_notary_services_price;
use App\cl_notary_order;
use App\cl_groups;

use PDF;

class CalcController extends Controller
{
    public function index() {

        return view('pages.calculator');

    }

    public function actions() {
        return cl_notary_actions::all();
    }

    public function once_action($id) {
        return cl_notary_actions::find($id);
    }

    public function once_service($id) {
        return cl_notary_services::find($id);
    }

    public function services($id) {
        return cl_notary_services::where('parent_id', $id)->get();
    }

    public function order_update(Request $request, $id)
    {
        $service = cl_notary_order::find($id);

        $service->edit($request->all());

        return response()->json([
            'status' => 'ok'
        ]);
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

    public function get_notary_groups() {
        return cl_groups::all();
    }

    public function create_pdf($id)
    {
        $order = cl_notary_order::where('id', $id)->get();

        $data = [
            'price' => $order[0]['price'],
            'fio' => $order[0]['fio'],
            'code' => $order[0]['code']];
        $pdf = PDF::loadView('pages.pdf', $data);

        return $pdf->download($order[0]['code'].".pdf");
    }

}
