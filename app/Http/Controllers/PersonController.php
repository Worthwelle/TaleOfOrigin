<?php

namespace TaleOfOrigin\Http\Controllers;

use TaleOfOrigin\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PersonController extends Controller
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
            'tree_id' => 'required|integer',
            'name' => 'required',
            'birth' => 'nullable|date_format:Y-m-d',
            'death' => 'nullable|date_format:Y-m-d|after_or_equal:birth',
            'gender_id' => 'nullable|integer',
            'religion' => 'nullable|integer',
            'cause_of_death' => 'nullable',
            'notes' => 'nullable'
        ]);
        
        $data = $request->all();
        $person = new Person($data);
        $person->save();
        return $person;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Cache::remember('Person'.$id, 60, function () use ($id) {
            return Person::with('tree')->find($id)->append('father','mother','children','siblings');
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
        $person = Person::find($id);
        if( !$person ) {
            return ['error' => '404'];
        }
        $data = $request->all();
        $person->fill($data);
        $person->save();
        return $person;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $person = Person::find($id);
        if( !$person ) {
            return ['error' => '404'];
        }
        $person->delete();
    }
}
