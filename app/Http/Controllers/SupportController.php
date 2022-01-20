<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;

class SupportController extends Controller
{

   protected $except = [
      'login'
   ];

   public function index(){

   }
}
