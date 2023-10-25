<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Laboratory\LabStoreRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Laboratory\StoreRequest;


class LaboratoryController extends Controller
{
    public function index()
    {
        $laboratory = User::where('role' , 'laboratory')->get();
        return response()->json([
            'data' => $laboratory ,
        ]);
    }

    public function store(LabStoreRequest $request)
    {
       

        try {
            $validatData = $request->validated();
            $Addlaboratory = User::create([

                'full_name' => $validatData['full_name'],
                'center_number' => $validatData['center_number'],
                'role' => $validatData['role'],
                'mobile' => $validatData['phone_number'],
                'password' => $validatData['password'],

            ]);

            return response()->json($Addlaboratory, 200);
        } catch (Exception $error) {
            return response()->json($error, 400);
        }
    }

   
}
