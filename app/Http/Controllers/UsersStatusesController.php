<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Users_statuses;

class UsersStatusesController extends Controller
{
    public function index()
   {
    $statuses = Users_statuses::all();
    $data= ['statuses' => $statuses];
    return response()->json($data);
 }
}
