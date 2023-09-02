<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreRequest;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $admins = User::where('role' , 'admin')->paginate(8);
        return response()->json([
            'data' => $admins ,
        ]);
    }
    public function store(StoreRequest $request)
    {
        try {
            $validatData = $request->validated();
            $addAdmin = User::create([
                'full_name' => $validatData['full_name'],
                'role' => $validatData['role'],
                'email' => $validatData['email'],
                'password' => Hash::make( $validatData['password'])
            ]);
            return response()->json($addAdmin, 200);
        } catch (Exception $error) {
            return response()->json($error, 400);
        }
    }

    public function destroy($admin_id)
    {
        try {
            $admin = User::find($admin_id);
            $deleteAdmin = $admin->delete();
            if ($deleteAdmin) {
                return response()->json('The Post removed successfuly.', 200);
            } else {
                return response()->json('Removing the post is failed', 400);
            }
        } catch (Exception $error) {
            return response()->json($error, 400);
        }
    }
}
