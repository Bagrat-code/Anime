<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AnimeController;

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

Route::get('/', function () {
  $animes = DB::select("SELECT * FROM animes");
  return view('welcome', ["animes" => $animes]);
});

Route::get('/anime/{id}', [AnimeController::class,'anime']); 

// Lorsque l'utilisateur n'est pas connecté, il est redigiré vers la page de connexion lorsqu'il clique sur Ecrire une critique. 
// S'il est connecté, il pourra écrire une critique.

//  Route post et get de la page new review. Dans l'url, on a /anime/l'id de l'anime/new_review

Route::post('/anime/{id}/new_review', function ($id) {

  if (Auth::user()) {
    $anime = DB::select("SELECT * FROM animes WHERE id = ?", [$id])[0];
    return view('new_review', ["anime" => $anime]);
  } else  {
    return view('login');
  }
});

Route::get('/anime/{id}/new_review', function ($id) {

  if (Auth::user()) {
    $anime = DB::select("SELECT * FROM animes WHERE id = ?", [$id])[0];
    return view('new_review', ["anime" => $anime]);
  } else  {
    return view('login');
  }
});

Route::get('/login', function () {
  return view('login');
});

// Si le formulaire de connexion est rempli correctement, l'utlisateur est connecté, sinon on affiche un message mot de passe ou identifiant incorrect
Route::post('/login', function (Request $request) {
  $validated = $request->validate([
    "username" => "required",
    "password" => "required",
  ]);
  if (Auth::attempt($validated)) {
    return redirect()->intended('/');
  }
  return back()->withErrors([
    'username' => 'Mot de passe ou identifiant incorrect.',
  ]);
});

Route::get('/signup', function () {
  return view('signup');
});

Route::post('signup', function (Request $request) {
  $validated = $request->validate([
    "username" => "required",
    "password" => "required",
    "password_confirmation" => "required|same:password"
  ]);
  $user = new User();
  $user->username = $validated["username"];
  $user->password = Hash::make($validated["password"]);
  $user->save();
  Auth::login($user);
  return redirect('/');
});

Route::post('signout', function (Request $request) {
  Auth::logout();
  $request->session()->invalidate();
  $request->session()->regenerateToken();
  return redirect('/');
});

Route::get('/top', function () {
  $anime = DB::select("SELECT * FROM animes");
  return view('top', ["anime" => $anime]);
});


Route::post('/anime/{id}/add_to_watch_list', function ($id) {

  if (Auth::user()) {
    $anime = DB::select("SELECT * FROM animes WHERE id = ?", [$id])[0];
    return view('watchlist', ["anime" => $anime]);
  } else  {
    return view('login');
  }
});


Route::get('/anime/{id}/add_to_watch_list', function ($id) {

  if (Auth::user()) {
    $anime = DB::select("SELECT * FROM animes WHERE id = ?", [$id])[0];
    return view('watchlist', ["anime" => $anime]);
  } else  {
    return view('login');
  }
});

// Lorsque l'utilisateur n'est pas connecté, il est redigiré vers la page de connexion lorsqu'il clique sur Ma Watchlist. 
// S'il est connecté, il pourra accéder à la page et consulter sa watchlist.
Route::post('/watchlist', function () {

  if (Auth::user()) {
    $anime = DB::select("SELECT * FROM animes ");
    return view('watchlist', ["anime" => $anime]);
  } else {
    return view('login');
  }
});

Route::get('/watchlist', function () {

  if (Auth::user()) {
    $anime = DB::select("SELECT * FROM animes ");
    return view('watchlist', ["anime" => $anime]);
  } else {
    return view('login');
  }
});
