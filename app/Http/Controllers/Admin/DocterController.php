<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Docter\StoreRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DocterController extends Controller
{
    public function index()
    {
        $docters = User::where('role', 'docter')->paginate(8);
        return response()->json([
            'data' => $docters,
        ] , 200);
    }
    public function store(StoreRequest $request)
    {
        
        try {
            $validatData = $request->validated();
            $AddDocter = User::create([
                'full_name' => $validatData['full_name'],
                'national_code' => $validatData['national_code'],
                'docter_code' => $validatData['docter_code'],
                'role' => $validatData['role'],
                'mobile' => $validatData['phone_number'],
                'password' => $validatData['password'],
            ]);
            return response()->json($AddDocter, 200);
        } catch (Exception $error) {
            return response()->json($error, 400);
        }
    }

    public function destroy($docter_id)
    {
        try {
            $docter = User::find($docter_id);
            $deleteDocter = $docter->delete();
            if ($deleteDocter) {
                return response()->json('The Post removed successfuly.', 200);
            } else {
                return response()->json('Removing the post is failed', 400);
            }
        } catch (Exception $error) {
            return response()->json($error, 400);
        }
    }
}
