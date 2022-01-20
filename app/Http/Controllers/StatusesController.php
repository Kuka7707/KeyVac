<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Statuses;

class StatusesController extends Controller
{
    public function index()
    {
       
            $statuses = Statuses::all();
            $data=['statuses' => $statuses];
        
            return response()->json($data); 
    }
    //
}
