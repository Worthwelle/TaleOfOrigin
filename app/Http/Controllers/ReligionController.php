<?php

namespace TaleOfOrigin\Http\Controllers;

use TaleOfOrigin\Religion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ReligionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'title' => 'required'
        ]);
        
        $data = $request->all();
        $religion = new Religion($data);
        $religion->save();
        return $religion;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Cache::remember('Religion'.$id, 60, function () use ($id) {
            return Religion::find($id);
        });
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $religion = Religion::find($id);
        if( !$religion ) {
            return ['error' => '404'];
        }
        $data = $request->all();
        $religion->fill($data);
        $religion->save();
        return $religion;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $religion = Religion::find($id);
        if( !$religion ) {
            return ['error' => '404'];
        }
        $religion->delete();
    }
}
