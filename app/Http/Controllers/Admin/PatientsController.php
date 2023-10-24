<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;

class PatientsController extends Controller
{
    public function index()
    {
         $patients = Patient::paginate(8);

         return response()->json([
           'data' => $patients ,
         ],200 );
    }
}
