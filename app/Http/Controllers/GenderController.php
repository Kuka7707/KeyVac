<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GenderController extends Controller
{
    //
    public function index()
    {
       
        $genders = Genders::all();
        $data=['genders' => $genders];
    
        return response()->json($data); 
}
}
