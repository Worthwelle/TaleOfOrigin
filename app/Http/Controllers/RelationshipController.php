<?php

namespace TaleOfOrigin\Http\Controllers;

use TaleOfOrigin\Relationship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class RelationshipController extends Controller
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
        $relationship = new Relationship($data);
        $relationship->save();
        return $relationship;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Cache::remember('Relationship'.$id, 60, function () use ($id) {
            return Relationship::find($id);
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
        $relationship = Relationship::find($id);
        if( !$relationship ) {
            return ['error' => '404'];
        }
        $data = $request->all();
        $relationship->fill($data);
        $relationship->save();
        return $relationship;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $relationship = Relationship::find($id);
        if( !$relationship ) {
            return ['error' => '404'];
        }
        $relationship->delete();
    }
}
