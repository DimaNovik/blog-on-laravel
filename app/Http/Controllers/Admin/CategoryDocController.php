<?php

namespace App\Http\Controllers\Admin;

use App\CategoryDoc;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryDocController extends Controller
{
    public function index() {

        $categories = CategoryDoc::all();

        return view('admin.categories_doc.index', ['categories' => $categories]);
    }

    public function create() {
        return view('admin.categories_doc.create');
    }

    public function store(Request $request) {
        $this->validate($request, [
            'title' => 'required'
        ]);

        CategoryDoc::create($request->all());
        return redirect()->route('categories_doc.index');
    }

    public function edit($id) {
        $category = CategoryDoc::find($id);
        return view('admin.categories_doc.edit', ['category'=> $category]);
    }

    public function update(Request $request, $id) {

        $this->validate($request, [
            'title' => 'required'
        ]);

        $category = CategoryDoc::find($id);

        $category->update($request->all());

        return redirect()->route('categories_doc.index');
    }

    public function destroy($id) {
        CategoryDoc::find($id)->delete();

        return redirect()->route('categories_doc.index');
    }
}
