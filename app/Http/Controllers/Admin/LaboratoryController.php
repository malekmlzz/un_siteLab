<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;


class LaboratoryController extends Controller
{
    public function index()
    {
        $laboratory = User::where('role' , 'laboratory')->paginate(8);
        return response()->json([
            'data' => $laboratory ,
        ]);
    }

    public function store(Request $request)
    {
        try {
            
            $Addlaboratory = User::create([

                'name' => $request->name,
                'Lab_code' => $request->Lab_code,
                'mobile' => $request->phon_number,
                'role' => $request->role,
                'password' =>Hash::make( $request->password)

            ]);

            return response()->json($Addlaboratory, 200);
        } catch (Exception $error) {
            return response()->json($error, 400);
        }
    }

    public function delete($laboratory_id)
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
