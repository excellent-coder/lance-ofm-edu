<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\SCStudent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;


class AuthController extends Controller
{
    public $redirect = '/scs';

    public function registerPage()
    {
        return view('auth.register');
    }

    public function loginPage()
    {
        return view('auth.login');
    }

    public function register(Request $request)
    {
        $valid = Validator::make(
            $request->all(),
            [
                'username' => 'required|unique:s_c_students,username',
                'email' => 'required|unique:s_c_students,email',

                'first_name' => 'required',
                'last_name' => 'required',

                'dob' => 'required',
                'terms' => 'required',
                'phone' => 'required',
                'password' => 'required|min:8|max:16',
            ],
            ['terms.required' => 'You must agree to our terms']
        );

        if ($valid->fails()) {
            return [
                'message' => 'You have some Errors',
                'errors' => $valid->errors()->all()
            ];
        }

        $s = new SCStudent();

        $s->username = $request->username;
        $s->email = $request->email;

        $s->first_name = $request->first_name;
        $s->last_name = $request->last_name;
        $s->middle_name = $request->middle_name;

        $s->phone = $request->phone;
        $s->dob = $request->dob;

        $s->password = bcrypt($request->password);

        $s->save();

        if (session('scs.redirect')) {
            $this->redirect = session('scs.redirect');
            Session::forget('scs.redirect');
        }
        Auth::guard('scs')->login($s);
        return [
            'message' => "You have successfully registered",
            'type' => 'success',
            'status' => 200,
            'to' => $this->redirect
        ];
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
        // return auth('scs')->user();
        $valid = Validator::make(
            $request->all(),
            [
                'username' => 'required',
                'password' => 'required',
            ]
        );

        if ($valid->fails()) {
            return [
                'message' => 'Some fields Missing',
                'errors' => $valid->errors()->all()
            ];
        }

        $username = $request->username;
        $password = $request->password;
        $remember = $request->filled('remember');

        $user = false;
        $auth = User::where('email', $username)->first();
        if ($user) {
            if (password_verify($password, $user->password)) {
                $user = $auth;
                auth('scs')->login($user, $remember);
            }
        } else if ($user = $this->loginUsername($username, $password)) {
            auth('scs')->login($user, $remember);
        } else if ($user = $this->loginMatric($username, $password)) {
            auth('scs')->login($user, $remember);
        }

        if ($user) {
            return [
                'message' => "Successfully Logged",
                'type' => 'success',
                'status' => 200,
                'to' => $this->redirect
            ];
        }
        return [
            'message' => 'invalid credentials',
            'type' => 'error',
            'status' => 200
        ];
    }

    protected function loginUsername($username, $password)
    {
        $user = SCStudent::where('username', $username)->first();
        if ($user) {
            if (password_verify($password, $user->password)) {
                return $user;
            }
        }
        return false;
    }

    protected function loginMatric($no, $password)
    {
        $user = SCStudent::where('matric_no', $no)->first();
        if ($user) {
            if (password_verify($password, $user->password)) {
                return $user;
            }
        }
        return false;
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
