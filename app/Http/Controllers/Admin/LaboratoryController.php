<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Laboratory\StoreRequest;


class LaboratoryController extends Controller
{
    public function index()
    {
        $laboratory = User::where('role' , 'laboratory')->paginate(8);
        return response()->json([
            'data' => $laboratory ,
        ]);
    }

    public function store(StoreRequest $request)
    {
       

        try {
            $validatData = $request->validated();
            $Addlaboratory = User::create([

                'full_name' => $validatData['full_name'],
                'lab_code' => $validatData['lab_code'],
                'role' => $validatData['role'],
                'mobile' => $validatData['phon_number'],
                'password' => Hash::make($validatData['password'],),

            ]);

            return response()->json($Addlaboratory, 200);
        } catch (Exception $error) {
            return response()->json($error, 400);
        }
    }

    public function destroy($laboratory_id)
    {
        try {
            $laboratory = User::find($laboratory_id);
            $deletelaboratory = $laboratory->delete();

            if ($deletelaboratory) {
                return response()->json('The Post removed successfuly.', 200);
            } else {
                return response()->json('Removing the post is failed', 400);
            }
        } catch (Exception $error) {
            return response()->json($error, 400);
        }
    }
}
