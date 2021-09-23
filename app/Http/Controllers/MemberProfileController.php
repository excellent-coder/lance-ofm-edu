<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;

class MemberProfileController extends Controller
{
    public function profile()
    {
        return 'comming soon';
    }

    public function updateProfile(Request $request)
    {
        return $request->all();
    }
}
