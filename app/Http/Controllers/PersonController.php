<?php

namespace TaleOfOrigin\Http\Controllers;

use TaleOfOrigin\Person;
use TaleOfOrigin\PersonRelationship;
use TaleOfOrigin\Role;
use TaleOfOrigin\Relationship;
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
        return Person::all();
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
            'notes' => 'nullable',
            'mother_id' => 'nullable',
            'father_id' => 'nullable'
        ]);
        
        $data = $request->all();
        $person = new Person($data);
        $person->save();
        if($person->gender == "Male") {
            $child_role = "Son";
        }
        elseif($person->gender == "Female") {
            $child_role = "Daughter";
        }
        else {
            $child_role = "Child";
        }
        
        if(isset($data['mother_id'])) {
            PersonRelationship::create([
                'person1_id' => $data['mother_id'],
                'role1_id' => Role::where('title', '=', "Mother")->first()->id,

                'person2_id' => $person->id,
                'role2_id' => Role::where('title', '=', $child_role)->first()->id,

                'relationship_id' => Relationship::where('title', '=', 'Parent/Child')->first()->id
            ]);
        }
        if(isset($data['father_id'])) {
            PersonRelationship::create([
                'person1_id' => $data['father_id'],
                'role1_id' => Role::where('title', '=', "Father")->first()->id,

                'person2_id' => $person->id,
                'role2_id' => Role::where('title', '=', $child_role)->first()->id,

                'relationship_id' => Relationship::where('title', '=', 'Parent/Child')->first()->id
            ]);
        }
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
