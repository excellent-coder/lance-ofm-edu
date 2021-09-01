<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminProfileController extends Controller
{
    public function index()
    {
        return view('admin.pages.profile.index');
    }

    public function update(Request $request)
    {
        $user = User::find(auth()->id());
        $valid = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'username' => "required|unique:users,username,$user->id",
                'email' => "required|unique:users,username,$user->id"
            ]
        );

        if ($valid->fails()) {
            return [
                'message' => 'You have some errors',
                'errors' => $valid->errors()->all()
            ];
        }

        if (!password_verify($request->password, $user->password)) {
            return [
                'message' => 'old password is not correct',
                'type' => 'error',
                'status' => 200
            ];
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->save();
        return [
            'message' => 'Profile updated successfully',
            'status' => 200,
            'type' => 'success',
            'reload' => true
        ];
    }
}
