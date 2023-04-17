<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth/login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Route::get('/new-project', [App\Http\Controllers\HomeController::class, 'index'])->name('newproject');
Route::get('/new-project', function () {
    $users = DB::table('users')->get();

    return view('newproject', [
        'users' => $users
    ]);
});


/** Get all projects -- ovo je visak */
Route::get('/allprojects', function () {
    $projects = DB::table('projekti')->get();

    if (is_null($projects)) {
        return view('projects', [
            'projects' => []
        ]);
    }

    return view('projects', [
        'projects' => $projects
    ]);
})->name('projects');



Route::get('/myprojects', function () {
    $userId = Auth::user()->id;

    $projects = DB::table('projekti')->where("voditelj", "=", "{$userId}")->get();

    $projects_participant = DB::table('projekti')
            ->whereExists(function ($query) use ($userId) {
                $query->select(DB::raw(1))
                      ->from('na_projektu')
                      ->whereRaw('projekti.naziv_projekta = na_projektu.projektime') // Replace 'naziv_projekta' with the actual column name in "projekti" table and 'projektime' with the actual column name in "na_projektu" table
                      ->where('userid', $userId); // Replace 'user_id' with the actual foreign key column in "na_projektu" table
            })
            ->get();


    if (is_null($projects)) {
        $projects = [];
    }

    return view('projects', [
        'projects' => $projects,
        'projects_participant' => $projects_participant
    ]);
})->name('projects');


Route::post('/create-project', function (Request $request) {

    DB::table('projekti')->insert([
        'naziv_projekta' => $request->naziv_projekta,
        'opis_projekta' => $request->opis_projekta,
        'cijena_projekta' => $request->cijena_projekta,
        'obavljeni_poslovi' => $request->obavljeni_poslovi,
        'voditelj' => Auth::user()->id
    ]);

    $selectedUserIds = $request->input('selectedUsers');

    // Loop through the selected user IDs and insert them into the database
    foreach ($selectedUserIds as $userId) {
        DB::table('na_projektu')->insert([
            'projektime' => $request->naziv_projekta,
            'userid' => $userId
        ]);
    }


    return redirect('/myprojects');
})->name('create-project');


Route::get('/editproject/{naziv_projekta?}', function($naziv_projekta = null) {

    $projects = DB::table('projekti')->where("naziv_projekta", "=", "{$naziv_projekta}")->get();

    return view('editproject', [
        'project' => $projects[0],
        'userId' => Auth::user()->id,
        'stari_naziv' => $projects[0]->naziv_projekta
    ]);

})->name('editproject');

Route::post('/update-project/{stari_naziv?}', function (Request $request, $stari_naziv = null) {

    DB::table('projekti')->where('naziv_projekta', '=', $stari_naziv)
        ->update([
            'naziv_projekta' => $request->naziv_projekta,
            'opis_projekta' => $request->opis_projekta,
            'cijena_projekta' => $request->cijena_projekta,
            'obavljeni_poslovi' => $request->obavljeni_poslovi
        ]);

    return redirect('/myprojects');
})->name('update-project');
