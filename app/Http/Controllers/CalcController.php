<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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
            'inn' => $order[0]['inn'],
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
            $inn = $order[0]['inn'];
        }

        $data = [
            'price' => $total,
            'fio' => $fio,
            'code' => $code,
            'inn' => $inn
        ];

        $pdf = PDF::loadView('pages.pdf', $data);

        return $pdf->download("Зведений " . $order[0]['code'] . ".pdf");
    }

    public function create_score_pdf($id)
    {
        $order = cl_notary_order::where('id', $id)->get();


        $services = json_decode($order[0]['service_id']);
        $region = $order[0]['region_id'];
     
        $data = array();
        $total = 0;
        $name;
        $code;

        foreach ($services as $value) {
            $service = cl_notary_services::where('id', $value->service)->get();
            $total += $value->price * $value->count;
            if($region == 1) {
                $name = $service[0]['name'];
                $code = $service[0]['code'];
            } else if($region == 2) {
                $name = $service[0]['name_mik'];
                $code = $service[0]['code_mik'];
            } else {
                $name = $service[0]['name_kher'];
                $code = $service[0]['code_kher'];
            }
            
            array_push($data, [
                'name' => $name,
                'code' => $code,
                'price' => $value->price,
                'count' => $value->count,
                'all' => $value->price * $value->count,
                'total' => $total,
                'region' => $region
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
        $name;
        $code;

        foreach ($actions as &$value) {

            $order = cl_notary_order::where('id', $value)->get();

            $services = json_decode($order[0]['service_id']);
            $region = $order[0]['region_id'];


            foreach ($services as &$item) {
                $service = cl_notary_services::where('id', $item->service)->get();
                $total += $item->price * $item->count;

                if($region == 1) {
                    $name = $service[0]['name'];
                    $code = $service[0]['code'];
                } else if($region == 2) {
                    $name = $service[0]['name_mik'];
                    $code = $service[0]['code_mik'];
                } else {
                    $name = $service[0]['name_kher'];
                    $code = $service[0]['code_kher'];
                }

                array_push($data, [
                    'name' => $name,
                    'code' => $code,
                    'price' => $item->price,
                    'count' => $item->count,
                    'all' => $item->price * $item->count,
                    'total' => $total,
                    'region' => $region
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
        $region = $_GET['region'];

        $order = cl_notary_order::where('user_id', $id)
            ->where('action_date', '>=', $firstDay)
            ->where('action_date', '<=', $lastDay)
            ->where('type', '=', 1)->get();

        $userInfo = cl_users::where('id', $id)->get();

        $groupInfo = cl_groups::where('id', $userInfo[0]['group_id'])->get();

        $data = array();
        $total = 0;

        foreach ($order as &$value) {

            $data_service = array();
            $total += $value['price'];

            $services = json_decode($value['service_id']);

            foreach ($services as &$item) {
                $service = cl_notary_services::where('id', $item->service)->get();
     
                if(isset($service[0])) {
                    if($region == 1) {
                        $code = $service[0]['code'];
                    } else if($region == 2) {
                        $code = $service[0]['code_mik'];
                    } else {
                        $code = $service[0]['code_kher'];
                    }
                }
                array_push($data_service, [
                    'actions' => $code,
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
                'userName' => $userInfo[0]['name'],
                'userGroup' => $groupInfo[0]['name']
            ]);
        }

        if(empty( $data)) return;

        $pdf = PDF::loadView('pages.registry', compact('data'));

        return $pdf->download("Registry.pdf");
    }

    public function create_group_registry_pdf($id)
    {
        $firstDay = $_GET['start'];
        $lastDay = $_GET['end'];
        $region = $_GET['region'];

        $order = cl_notary_order::where('office_id', $id)
            ->where('action_date', '>=', $firstDay)
            ->where('action_date', '<=', $lastDay)
            ->where('region_id', $region)
            ->where('type', '=', 1)->get();

        $groupInfo = cl_groups::where('group_code', $id)
        ->where('region_id', '=', $region)->get();

        $data = array();
        $total = 0;
        $code;

        foreach ($order as &$value) {

            $data_service = array();
            $total += $value['price'];

            $services = json_decode($value['service_id']);

            foreach ($services as &$item) {
                $service = cl_notary_services::where('id', $item->service)->get();
                if(isset($service[0])) {
                    if($region == 1) {
                        $code = $service[0]['code'];
                    } else if($region == 2) {
                        $code = $service[0]['code_mik'];
                    } else {
                        $code = $service[0]['code_kher'];
                    }
                }

                array_push($data_service, [
                    'actions' => $code,
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
                'userGroup' => $groupInfo[0]['name']
            ]);
        }

        if(empty( $data)) return;

        $pdf = PDF::loadView('pages.registry', compact('data'));

        return $pdf->download("Registry.pdf");
    }

    public function create_total_score_pdf(Request $request, $id) {
        $query = $request->all();
        $data = array();
        $region = $query['region'];
        $orders = cl_notary_order::where('user_id', $id)
            ->where('action_date', '>=', $query['start'])
            ->where('action_date', '<=', $query['end'])
            ->where('type', '=', 1)
            ->get()
            ->toArray();

        $services = cl_notary_services::select('subgroup_id', 'name', 'name_kher', 'name_mik', 'code', 'code_kher','code_mik',
        'cl_notary_services_prices.service_id', 'cl_notary_services_prices.price', 'cl_notary_services_prices.price_kher', 'cl_notary_services_prices.price_mik')
            ->leftJoin('cl_notary_services_prices', 'cl_notary_services.id', '=', 'cl_notary_services_prices.service_id')
            ->distinct()
            ->orderBy('code')
            ->get()
            ->toArray();

        $userInfo = cl_users::where('id', $id)->get();
        $groupInfo = cl_groups::where('id', $userInfo[0]['group_id'])->get();

        foreach ($services as &$service) {
            if($region == 1) {
                $name = $service['name'];
                $code = $service['code'];
                $price = $service['price'];
            } else if($region == 2) {
                $name = $service['name_mik'];
                $code = $service['code_mik'];
                $price = $service['price_mik'];
            } else {
                $name = $service['name_kher'];
                $code = $service['code_kher'];
                $price = $service['price_kher'];
            }

            foreach ($orders as &$order) {
                $order_service = json_decode($order['service_id']);

                foreach ($order_service as &$once) {

                    if($once->code == $code && $once->price == $price && $once->service == $service['service_id'] && isset($name)) {

                        array_push($data, [
                            'subgroup' => $service['subgroup_id'],
                            'code' => $code,
                            'name' => $name,
                            'price' =>  $price,
                            'count' => $once->count,
                            'total' => $price,
                        ]);
                     
                    }
                }
            }

            array_push($data, [
                'subgroup' => $service['subgroup_id'],
                'code' => $code,
                'name' =>  $name,
                'price' => $price,
                'count' => 0,
                'total' => 0,
                'userName' => $userInfo[0]['name'],
                'userGroup' => $groupInfo[0]['name']
            ]);
        }
        
        $res  = array();
        foreach($data as $vals){
            if(array_key_exists($vals['code'],$res)){
                $res[$vals['code']]['count'] += $vals['count'];
            }
            else{
                $res[$vals['code']] = $vals;
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
            ->where('region_id', '=', $query['region'])
            ->where('type', '=', 1)
            ->get()
            ->toArray();

        $services = cl_notary_services::select('subgroup_id', 'name', 'name_kher', 'name_mik', 'code', 'code_kher', 'code_mik', 
        'cl_notary_services_prices.service_id', 'cl_notary_services_prices.price', 'cl_notary_services_prices.price_kher', 'cl_notary_services_prices.price_mik')
            ->leftJoin('cl_notary_services_prices', 'cl_notary_services.id', '=', 'cl_notary_services_prices.service_id')
            ->distinct()
            ->orderBy('code')
            ->get()
            ->toArray();

        $groupInfo = cl_groups::where('group_code', $id)
        ->where('region_id', '=', $query['region'])
        ->get();

        $region = $query['region'];

        foreach ($services as &$service) {
                if($region == 1) {
                    $name = $service['name'];
                    $code = $service['code'];
                    $price = $service['price'];
                } else if($region == 2) {
                    $name = $service['name_mik'];
                    $code = $service['code_mik'];
                     $price = $service['price_mik'];
                } else {
                    $name = $service['name_kher'];
                    $code = $service['code_kher'];
                    $price = $service['price_kher'];
                }
            foreach ($orders as &$order) {
                $order_service = json_decode($order['service_id']);

                foreach ($order_service as &$once) {

                    if($once->code == $code && $once->price == $price && $once->service == $service['service_id'] && isset($name)) {
                    
                        array_push($data, [
                            'subgroup' => $service['subgroup_id'],
                            'code' => $code,
                            'name' => $name,
                            'price' =>  $price ,
                            'count' => $once->count,
                            'total' => $price,
                        ]);
                    }
                }
            }

            array_push($data, [
                'subgroup' => $service['subgroup_id'],
                'code' => $code,
                'name' =>  $name,
                'price' => $price,
                'count' => 0,
                'total' => 0,
                'userGroup' => $groupInfo[0]['name']
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
