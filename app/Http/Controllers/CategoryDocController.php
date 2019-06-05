<?php

namespace App\Http\Controllers;

use App\CategoryDoc;
use \Auth;
use Illuminate\Http\Request;

class CategoryDocController extends Controller
{
    public function index() {

        $categories = CategoryDoc::all();

        return view('pages.cabinet', ['categories'=>$categories]);
    }
}
