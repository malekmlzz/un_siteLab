<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class DeleteUsersController extends Controller
{
    public function destroy($user_id)
    {
        try {
            $docter = User::find($user_id);
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
