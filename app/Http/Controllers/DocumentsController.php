<?php

namespace App\Http\Controllers;

use App\Documents;
use App\CategoryDoc;
use \Auth;
use Illuminate\Http\Request;

class DocumentsController extends Controller
{
    public function index($id) {

        $documents = Documents::where('category', $id)->get();
        $category = CategoryDoc::where('id', $id)->firstOrFail();

        return view('pages.documents', compact('documents','category'));
    }
}
