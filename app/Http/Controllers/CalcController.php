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

    public function order_delete(Request $request, $id)
    {
        $service = cl_notary_order::find($id);

        $service->delete($request->all());

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
            'code' => $order[0]['code'] . ";"];

        $pdf = PDF::loadView('pages.pdf', $data);

        return $pdf->download($order[0]['code'] . ".pdf");
    }

    public function create_group_pdf(Request $request)
    {

        $actions = $request->all();

        $actions = explode(',', $actions['array']);

        $data = array();
        $total = 0;
        $fio = '';
        $code = '';

        foreach ($actions as &$value) {
            $order = cl_notary_order::where('id', $value)->get();

            $total += $order[0]['price'];
            $code .= $order[0]['code'] . "; ";
            $fio = $order[0]['fio'];
        }

        $data = [
            'price' => $total,
            'fio' => $fio,
            'code' => $code
        ];

        $pdf = PDF::loadView('pages.pdf', $data);

        return $pdf->download("Зведений " . $order[0]['code'] . ".pdf");
    }

    public function create_score_pdf($id)
    {
        $order = cl_notary_order::where('id', $id)->get();

        $services = json_decode($order[0]['service_id']);

        $data = array();
        $total = 0;

        foreach ($services as &$value) {
            $service = cl_notary_services::where('id', $value->service)->get();
            $total += $value->price;

            array_push($data, [
                'name' => $service[0]['name'],
                'code' => $service[0]['code'],
                'price' => $value->price,
                'count' => $value->count,
                'all' => $value->price * $value->count,
                'total' => $total
            ]);
        }

        $pdf = PDF::loadView('pages.score', compact('data'));

        return $pdf->download($order[0]['code'] . "-рахунок.pdf");
    }

    public function create_group_score_pdf(Request $request)
    {

        $actions = $request->all();

        $actions = explode(',', $actions['array']);

        $data = array();
        $total = 0;

        foreach ($actions as &$value) {

            $order = cl_notary_order::where('id', $value)->get();

            $services = json_decode($order[0]['service_id']);


            foreach ($services as &$item) {
                $service = cl_notary_services::where('id', $item->service)->get();
                $total += $item->price * $item->count;


                array_push($data, [
                    'name' => $service[0]['name'],
                    'code' => $service[0]['code'],
                    'price' => $item->price,
                    'count' => $item->count,
                    'all' => $item->price * $item->count,
                    'total' => $total
                ]);
            }

        }

        $pdf = PDF::loadView('pages.score', compact('data'));

        return $pdf->download("Груповий-рахунок.pdf");
    }

    public function create_registry_pdf($id)
    {
        $firstDay = $_GET['start'];
        $lastDay = $_GET['end'];

        $order = cl_notary_order::where('user_id', $id)
            ->where('action_date', '>=', $firstDay)
            ->where('action_date', '<=', $lastDay)
            ->where('type', '=', 1)->get();

        $data = array();
        $total = 0;

        foreach ($order as &$value) {

            $data_service = array();
            $total += $value['price'];

            $services = json_decode($value['service_id']);

            foreach ($services as &$item) {
                $service = cl_notary_services::where('id', $item->service)->get();

                array_push($data_service, [
                    'actions' => $service[0]['code'],
                ]);
            }

            array_push($data, [
                'action_date' => $value['action_date'],
                'actions' => $data_service,
                'counts' => $value['count'],
                'fio' => $value['fio'],
                'price' => $value['price'],
                'invoice' => $value['invoice'],
                'pay_date' => $value['pay_date'],
                'total' => $total,
            ]);
        }
        
        $pdf = PDF::loadView('pages.registry', compact('data'));

        return $pdf->download("Registry.pdf");
    }

    public function create_total_score_pdf(Request $request, $id) {
        $query = $request->all();
        $data = array();

        $orders = cl_notary_order::where('user_id', $id)
            ->where('action_date', '>=', $query['start'])
            ->where('action_date', '<=', $query['end'])
            ->where('type', '=', 1)
            ->get()
            ->toArray();

        $services = cl_notary_services::select('subgroup_id', 'name','code', 'cl_notary_services_prices.price')
            ->leftJoin('cl_notary_services_prices', 'cl_notary_services.id', '=', 'cl_notary_services_prices.service_id')
            ->distinct()
            ->orderBy('code')
            ->get()
            ->toArray();


        foreach ($services as &$service) {
            foreach ($orders as &$order) {
                $order_service = json_decode($order['service_id']);

                foreach ($order_service as &$once) {

                    if($once->code == $service['code'] && $once->price === $service['price']) {

                        array_push($data, [
                            'subgroup' => $service['subgroup_id'],
                            'code' => $service['code'],
                            'name' => $service['name'],
                            'price' => $service['price'],
                            'count' => $once->count,
                            'total' => $service['price'],
                        ]);
                    }
                }
            }

            array_push($data, [
                'subgroup' => $service['subgroup_id'],
                'code' => $service['code'],
                'name' => $service['name'],
                'price' => $service['price'],
                'count' => 0,
                'total' => 0,
            ]);
        }


        $res  = array();
        foreach($data as $vals){
            if(array_key_exists($vals['code'],$res)){
                $res[$vals['code']]['count'] += $vals['count'];
            }
            else{
                $res[$vals['code']]  = $vals;
            }
        }

        $pdf = PDF::loadView('pages.total-score', compact('res'));
        return $pdf->download("ЗвітНотаріуса.pdf");
    }

    public function create_total_group_score_pdf(Request $request, $id) {
        $query = $request->all();
        $data = array();

        $orders = cl_notary_order::where('office_id', $id)
            ->where('action_date', '>=', $query['start'])
            ->where('action_date', '<=', $query['end'])
            ->where('type', '=', 1)
            ->get()
            ->toArray();

        $services = cl_notary_services::select('subgroup_id', 'name','code', 'cl_notary_services_prices.price')
            ->leftJoin('cl_notary_services_prices', 'cl_notary_services.id', '=', 'cl_notary_services_prices.service_id')
            ->distinct()
            ->orderBy('code')
            ->get()
            ->toArray();


        foreach ($services as &$service) {
            foreach ($orders as &$order) {
                $order_service = json_decode($order['service_id']);

                foreach ($order_service as &$once) {

                    if($once->code == $service['code'] && $once->price === $service['price']) {

                        array_push($data, [
                            'subgroup' => $service['subgroup_id'],
                            'code' => $service['code'],
                            'name' => $service['name'],
                            'price' => $service['price'],
                            'count' => $once->count,
                            'total' => $service['price'],
                        ]);
                    }
                }
            }

            array_push($data, [
                'subgroup' => $service['subgroup_id'],
                'code' => $service['code'],
                'name' => $service['name'],
                'price' => $service['price'],
                'count' => 0,
                'total' => 0,
            ]);
        }


        $res  = array();
        foreach($data as $vals){
            if(array_key_exists($vals['code'],$res)){
                $res[$vals['code']]['count'] += $vals['count'];
            }
            else{
                $res[$vals['code']]  = $vals;
            }
        }

        $pdf = PDF::loadView('pages.total-score', compact('res'));
        return $pdf->download("ЗвітНотаріуса.pdf");
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
