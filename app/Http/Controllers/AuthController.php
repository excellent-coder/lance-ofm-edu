<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public $redirect_url = '/portal';

    public function   __construct()
    {
        if (!empty(session('login.redirect'))) {
            $this->redirect_url =  session('login.redirect');
        }
    }

    public function signup(Request $request)
    {
        $valid = Validator::make(
            $request->all(),
            [
                'email' => 'required|max:190|unique:users,email',
                'password' => 'required|max:190|min:6',
            ]
        );

        if ($valid->fails()) {
            return [
                'message' => 'You have some errors',
                'errors' => $valid->errors()->all()
            ];
        }

        $user = new User;
        $user->email = $request->email;
        $user->password = password_hash($request->password, PASSWORD_BCRYPT);
        // $user->ceo = 1;
        $user->save();

        Auth::login($user);
        return [
            'status' => 200,
            'message' => 'Registration Successfull',
            'to' => 'portal'
        ];
    }

    public function login(Request $request)
    {
        // return $request->all();
        $valid = Validator::make(
            $request->all(),
            [
                'email' => 'required',
                'password' => 'required',
            ]
        );

        if ($valid->fails()) {
            return [
                'message' => 'Some fields Missing',
                'errors' => $valid->errors()->all()
            ];
        }

        $email = $request->email;
        $password = $request->password;
        $remember = !empty($request->remember);

        $user = User::where('email', $email)->first();
        if (!$user) {
            return [
                'message' => "This Email address $email is not registered on our school",
                'errors' => ['Email not found']
            ];
        }

        if (!password_verify($password, $user->password)) {
            return [
                'message' => 'Invalid Email or passwor',
                'errors' => []
            ];
        }

        Auth::login($user, $remember);
        return $this->redirect_url;

        return $request->all();
    }


    public function page($authPage)
    {
        $authPage = strtolower($authPage);

        switch ($authPage):
            case 'register':
            case 'signup':
            case 'sign-up':
                $tag = 'sign-up';
                break;
            case 'password':
                $tag = 'reset-password';
                break;
            case 'forgot-password';
                $tag = 'reset-password';
                break;
            default:
                $tag = $authPage;
        endswitch;

        $action = "<$tag></$tag>";

        return view('auth.auth', compact('action'));
    }
}
