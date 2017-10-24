<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['api'], 'prefix' => '/v1'], function () {
    Route::get('/version', function() {
        return response()->json([
            'app' => config('app.name'),
            'version' => config('app.version'),
            'api' => 'v1'
        ]);
    });
    Route::resource('gender', 'GenderController');
    Route::resource('religion', 'ReligionController');
    Route::resource('person', 'PersonController');
    Route::resource('tree', 'TreeController');
    Route::resource('relationship', 'RelationshipController');
    Route::resource('role', 'RoleController');
    Route::resource('person_relationship', 'PersonRelationshipController');
    Route::resource('user', 'UserController');
    Route::get('/trees/{id}', function($id) {
        $trees = Cache::remember('TreeIndexUser'.$id, 60, function () use ($id) {
            return TaleOfOrigin\Tree::where('user_id','=',$id)->with('people.gender')->get();
        });
        return $trees->toJson();
    });
});
