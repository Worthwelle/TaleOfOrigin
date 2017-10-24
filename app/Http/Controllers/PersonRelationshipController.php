<?php

namespace TaleOfOrigin\Http\Controllers;

use TaleOfOrigin\PersonRelationship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PersonRelationshipController extends Controller
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
            'person1_id' => 'required',
            'person2_id' => 'required',
            'relationship_id' => 'required',
            'role1_id' => 'required',
            'role2_id' => 'required'
        ]);
        
        $data = $request->all();
        $person_relationship = new PersonRelationship($data);
        $person_relationship->save();
        return $person_relationship;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Cache::remember('PersonRelationship'.$id, 60, function () use ($id) {
            return PersonRelationship::find($id);
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
        $person_relationship = PersonRelationship::find($id);
        if( !$person_relationship ) {
            return ['error' => '404'];
        }
        $data = $request->all();
        $person_relationship->fill($data);
        $person_relationship->save();
        return $person_relationship;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $person_relationship = PersonRelationship::find($id);
        if( !$person_relationship ) {
            return ['error' => '404'];
        }
        $person_relationship->delete();
    }
}
