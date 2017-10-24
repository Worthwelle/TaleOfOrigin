<?php

namespace TaleOfOrigin\Http\Controllers;

use TaleOfOrigin\Tree;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TreeController extends Controller
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
            'user_id' => 'required|integer',
            'title' => 'required'
        ]);
        
        $data = $request->all();
        $tree = new Tree($data);
        $tree->save();
        return $tree;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Cache::remember('Tree'.$id, 60, function () use ($id) {
            return Tree::with('people.gender')->findOrFail($id);
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
        $tree = Tree::find($id);
        if( !$tree ) {
            return ['error' => '404'];
        }
        $data = $request->all();
        $tree->fill($data);
        $tree->save();
        return $tree;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tree = Tree::find($id);
        if( !$tree ) {
            return ['error' => '404'];
        }
        $tree->delete();
    }
}
