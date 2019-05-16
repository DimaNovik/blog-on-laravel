<?php

namespace App\Http\Controllers\Admin;

use App\Anonses;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AnonsesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $anonses = Anonses::all();
        return view('admin.anonses.index', ['anonses'=>$anonses]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.anonses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'content' => 'required',
            'date' => 'required',
        ]);

        $anonses = Anonses::add($request->all());

        return redirect()->route('anonses.index');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $anonses = Anonses::find($id);

        return view('admin.anonses.edit', ['anonses'=> $anonses]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'content' => 'required',
            'date' => 'required',
        ]);

        $anonses = Anonses::find($id);
        $anonses->edit($request->all());

        return redirect()->route('anonses.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Anonses::find($id)->delete();

        return redirect()->route('anonses.index');
    }
}
