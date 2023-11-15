<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class allCenterController extends Controller
{
    public function index()
    {
        $users = User::whereIn('role', ['sonography', 'laboratory'])->paginate(10);
        // ارسال اطلاعات به صورت ریسپانس
        return response()->json(['users' => $users]);
    }
}
