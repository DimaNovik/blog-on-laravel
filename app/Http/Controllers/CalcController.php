<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\cl_notary_actions;
use App\cl_notary_services;
use App\cl_notary_services_price;
use App\cl_notary_order;
use App\cl_groups;
use App\cl_users;

use PDF;

class CalcController extends Controller
{
    public function index()
    {

        return view('pages.calculator');

    }

    public function actions()
    {
        return cl_notary_actions::all();
    }

    public function once_action($id)
    {
        return cl_notary_actions::find($id);
    }

    public function once_service($id)
    {
        return cl_notary_services::find($id);
    }

    public function services($id)
    {
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

    public function service_update(Request $request, $id)
    {
        $service = cl_notary_services::find($id);

        $service->edit($request->all());

        return response()->json([
            'status' => 'ok'
        ]);
    }


    public function create(Request $request)
    {
        return cl_notary_order::create($request->all());
    }

    public function orders($id)
    {
        return cl_notary_order::where('user_id', $id)->get();
    }

    public function all_orders()
    {
        return cl_notary_order::all();
    }

    public function get_notary_groups()
    {
        return cl_groups::all();
    }

    public function get_user_group($id)
    {
        return cl_groups::where('id', $id)->firstOrFail();
    }

    public function create_pdf($id)
    {
        $order = cl_notary_order::where('id', $id)->get();

        $data = [
            'price' => $order[0]['price'],
            'fio' => $order[0]['fio'],
            'code' => $order[0]['code']];

        $pdf = PDF::loadView('pages.pdf', $data);

        return $pdf->download($order[0]['code'] . ".pdf");
    }

    public function create_score_pdf($id)
    {
        $order = cl_notary_order::where('id', $id)->get();

        $services = json_decode($order[0]['service_id']);

        $data = array();

        foreach ($services as &$value) {
            $service = cl_notary_services::where('id', $value->service)->get();

            array_push($data, [
                'name' => $service[0]['name'],
                'code' => $service[0]['code'],
                'price' => $value->price,
                'count' => $value->count,
                'all' => $value->price * $value->count
            ]);
        }

        $pdf = PDF::loadView('pages.score', compact('data'));

        return $pdf->download($order[0]['code'] . "-рахунок.pdf");
    }


    // PRICE

    public function price($id)
    {
        return cl_notary_services_price::where('service_id', $id)->firstOrFail();
    }

    public function price_update(Request $request, $id)
    {
        $price = cl_notary_services_price::where('service_id', $id)->first();

        $price->editPrice($request->all());

        return response()->json([
            'status' => 'ok'
        ]);
    }

    public function price_all()
    {
        return cl_notary_services_price::all();
    }

    // USERS
    public function get_notary_users()
    {
        return cl_users::all();
    }

    public function get_once_user($id)
    {
        return cl_users::where('id', $id)->firstOrFail();
    }

    public function once_user_update(Request $request, $id)
    {
        $service = cl_users::find($id);

        $service->edit($request->all());

        return response()->json([
            'status' => 'ok'
        ]);
    }
}
