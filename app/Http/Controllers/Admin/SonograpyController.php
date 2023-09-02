<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sonograpy\StoreRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SonograpyController extends Controller
{
    public function index()
    {
        $sonography = User::where('role' , 'sonography')->paginate(8);
        return response()->json([
            'data' => $sonography ,
        ]);
    }

    public function store(StoreRequest $request)
    {

        
        $validatData = $request->validated();

        try {
            // $validatData = $request->validated();
            $AddSonograpy = User::create([

                'full_name' => $validatData['full_name'],
                'lab_code' => $validatData['lab_code'],
                'role' => $validatData['role'],
                'mobile' => $validatData['phon_number'],
                'password' => Hash::make($validatData['password'],),

            ]);

            return response()->json($AddSonograpy, 200);
        } catch (Exception $error) {
            return response()->json($error, 400);
        }
    }

    public function destroy($Sonograpy_id)
    {
       
        try {
            $Sonograpy = User::find($Sonograpy_id);
            $deleteSonograpy = $Sonograpy->delete();

            if ($deleteSonograpy) {
                return response()->json('The Post removed successfuly.', 200);
            } else {
                return response()->json('Removing the post is failed', 400);
            }
        } catch (Exception $error) {
            return response()->json($error, 400);
        }
    }
}
