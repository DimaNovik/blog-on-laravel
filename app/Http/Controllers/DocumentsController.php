<?php

namespace App\Http\Controllers;

use App\Documents;
use \Auth;
use Illuminate\Http\Request;

class DocumentsController extends Controller
{
    public function index() {

        $files = Documents::where('status', 0)->orderBy('id', 'desc')->take(9)->get();

        return view('pages.index', ['files'=>$files]);
    }
}
