<?php

namespace App\Http\Controllers\AjaxRequest;

use DB;
use Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AjaxRequestController extends Controller
{
     public function getcities( $county = 0 )
     {
          $citiesArray = DB::select( 'SELECT id, name FROM cities WHERE county_id = ? ORDER BY name ASC', [$county] );
          $response = [
               'status' => 'success',
               'cities' => $citiesArray
          ];
          return Response::json( $response );
     }

     public function addcity( Request $request )
     {
          $validator = Validator::make( $request->all(), [
               'county' => 'required|numeric',
               'city' => 'required|string|min:3|max:30',
          ]);

          if( $validator->fails() ){
               $response = $validator->errors();
               $code = 422;
          } else {
               $response = DB::insert( 'INSERT INTO cities (name, county_id) VALUES (?, ?)', [$request->city, $request->county] );
               $response = [ 'status' => $request->city ];
               $code = 200;
          }

          return Response::json( $response, $code );
     }

     public function updatecity( Request $request )
     {
          $validator = Validator::make( $request->all(), [
               'cityId' => 'required|numeric',
               'cityName' => 'required|string|min:3|max:30',
          ]);

          if( $validator->fails() ){
               $response = $validator->errors();
               $code = 422;
          } else {
               $response = DB::update( 'UPDATE cities SET name=? WHERE id=?', [$request->cityName, $request->cityId] );
               $response = [ 'status' => $request->city ];
               $code = 200;
          }

          return Response::json( $response, $code );
     }

     public function deletecity( Request $request )
     {
          $validator = Validator::make( $request->all(), [
               'cityId' => 'required|numeric'
          ]);

          if( $validator->fails() ){
               $response = $validator->errors();
               $code = 422;
          } else {
               $response = DB::delete( 'DELETE FROM cities WHERE id=?', [$request->cityId] );
               $response = [ 'status' => 'deleted' ];
               $code = 200;
          }

          return Response::json( $response, $code );
     }
}
