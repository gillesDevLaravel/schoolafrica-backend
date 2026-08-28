<?php

use App\Http\Controllers\DocumentController;
use App\Models\Classes;
use App\Models\School;
use App\Models\User;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
//Route::get('/rt', [\App\Http\Controllers\WSController::class, 'startRealTime'])->name('rt');

Route::get('docs', function(){
    return view('scribe.index');
});

Route::get('d1022fae-c2dc-4866-80fc-815802be3fc0-ca69a731-1d1a-49c0-aab2-3c8e09760706', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);


//Route::get('br', function () {
//    $user = User::select('users.id as id', 'users.idBourse as idBourse','users.isBourseUsed as isBourseUsed','users.name as name','users.phone as phone','users.nationality as nationality','users.codeun as codeun','users.codedeux as codedeux','users.city as city','users.country as country','users.email as email','users.gender as gender','users.username as username','users.birthday as birthday','users.password as password','users.cni as cni','users.idSchool as idSchool','users.idSection as idSection','users.photo as photo','users.created_at as created_at','users.updated_at as updated_at','users.created_by as created_by','users.updated_by as updated_by','users.adresse as adresse','users.idCycle as idCycle','users.idParent as idParent','users.idClasse as idClasse','users.firstname as firstname','users.placeofbirth as placeofbirth','users.situation as situation','users.repeater as repeater','users.matricule as matricule','users.phone as phone','schools.scholar_level as scholar_level', 'classes.name as classe_name','u2.name as parentName','classes.name as classeName','schools.name as school_name','schools.logo as school_logo')
//        ->join('schools','schools.id','=','users.idSchool')
//        ->join('classes', 'classes.id', "=", "users.idClasse")
//        ->join('users as u2', 'u2.id', "=", "users.idParent")
//        ->where([
//            'users.id' => 927,
//            'users.deleted' => 0,
//            'users.idClasse' => 10
//        ])
//        ->first();
//
//    $school = School::select('name', 'phone', 'website', 'email')->find(Classes::find(10)->idSchool);
//
//    $data = [
//        'name' => $user->name,
//        'class' => Classes::find($user->idClasse)->name,
//        'image' => $user->photo,
//        'matricule' => $user->matricule,
//        'number' => User::select('phone')->find($user->idParent)->phone, // Le numéro du parent
//        'annee_scolaire' => "2024-2025",
//        'logo' => $user->school_logo,
//        'school_name' => $user->school_name,
//        'school' => $school
//    ];
//
//    $filename = Str::slug($user->name);
//
//    $dompdf = new Dompdf();
//
//    // Récupérer la vue
//    return view("documents.carte-scolaire", $data);
////    $view = View::make('documents.carte-scolaire')->with($data);
//});
