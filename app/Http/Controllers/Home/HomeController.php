<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class HomeController extends Controller
{
     public function index() {
          $countiesArray = DB::select('select id, name from counties ORDER BY name ASC');
          return view('home.home', compact('countiesArray'));
     }
}
