<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

class AnimeController extends Controller
{
    public function anime($id) {
        $anime = DB::select("SELECT * FROM animes WHERE id = ?", [$id])[0];
        return view('anime', ["anime" => $anime]);
      }
}

?>