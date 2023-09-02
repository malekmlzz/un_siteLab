<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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

    public function store(Request $request)
    {

        // $validatData = $request->validated();

        try {
            // $validatData = $request->validated();
            $AddSonograpy = User::create([

                'name' => $request->username,
                'Lab_code' => $request->lab_code,
                'role' => $request->role,
                'mobile' => $request->phon_number,
                'password' => Hash::make($request->password),

            ]);

            return response()->json($AddSonograpy, 200);
        } catch (Exception $error) {
            return response()->json($error, 400);
        }
    }

    public function delete($Sonograpy_id)
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
