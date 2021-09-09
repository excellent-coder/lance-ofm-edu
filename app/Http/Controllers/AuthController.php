<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Student;
use App\Models\SCStudent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    protected $redirect = '/dashboard';

    public function registerPage()
    {
        return view('auth.register');
    }

    public function loginPage()
    {
        return view('auth.login');
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
            'to' => $this->redirect,
        ];
    }

    public function login(Request $request)
    {
        // return $request->all();

        $valid = Validator::make(
            $request->all(),
            [
                'username' => 'required',
                'password' => 'required',
                'login_as' => 'required'
            ]
        );

        if ($valid->fails()) {
            return [
                'message' => 'Some fields Missing',
                'errors' => $valid->errors()->all()
            ];
        }

        $login_as = $request->login_as;
        if (!in_array($login_as, ['Member', 'SCStudent', 'Student'])) {
            return [
                'message' => 'Unable To authenticate',
                'type' => 'error',
                'status' => 200
            ];
        }

        $username = $request->username;
        $password = $request->password;
        $remember = $request->filled('remember');

        $user = false;

        switch ($login_as) {
            case 'Member':
                $log = $this->memberLogin($username, $password, $remember);
                if ($log) {
                    return $log;
                }
                break;
            case 'Student':
                $log = $this->studentLogin($username, $password, $remember);
                if ($log) {
                    return $log;
                }
                break;
            case 'SCStudent':
                break;
            default:
                return [
                    'message' => 'Invalid credentials',
                    'type' => 'error',
                    'status' => 200
                ];
                break;
        }
        $user = SCStudent::where('email', $username)->first();

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

    protected function memberLogin($id, $password, $remember)
    {
        $user = Member::where('member_id', $id)->first();
        if ($user) {
            if (password_verify($password, $user->password)) {
                auth('mem')->login($user, $remember);
                return [
                    'message' => "Successfully Logged in",
                    'to' => $this->redirect,
                    'status' => 200
                ];
            }
        }

        return false;
    }

    protected function studentLogin($id, $password, $remember)
    {
        $user = Student::where('matric_no', $id)->first();
        if ($user) {
            if (password_verify($password, $user->password)) {
                auth('pgs')->login($user, $remember);
                return [
                    'message' => "Successfully Logged in",
                    'to' => $this->redirect,
                    'status' => 200
                ];
            }
        }

        return false;
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


    public function logout()
    {
        foreach (['scs', 'pgs', 'mem'] as $guard) {
            auth($guard)->logout();
        }
        return redirect('/');
    }
}
