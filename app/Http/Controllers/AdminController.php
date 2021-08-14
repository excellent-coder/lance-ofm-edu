<?php

namespace App\Http\Controllers;

use App\Models\Ceo;
use DocuSign\eSign\Model\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    protected $redirect = '/admin';

    public function __construct()
    {
    }

    public function ceo(Request $request)
    {
        return Auth::guard('ceo')->user();
        // $ceo = new Ceo();
        // $ceo->name = 'Tested and trusted';
        // $ceo->email = $request->email;
        // $ceo->password = bcrypt($request->password);

        // $ceo->save();

        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (Auth::guard('ceo')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {

            return redirect()->intended('/admin-done');
        }
        return back()->withInput($request->only('email', 'remember'));
    }

    public function loginPage()
    {
        return view('admin.pages.login');
    }

    protected function loginUsername($username, $pass)
    {
        $user = User::where('username', $username)->first();
        if ($user) {
            if (password_verify($pass, $user->password)) {
                return $user;
            }
        }

        return false;
    }
    public function login(Request $request)
    {
        $this->redirect = route('admin.dashboard');
        if (session('admin.redirect')) {
            $this->redirect = session('admin.redirect');
        }

        $valid = Validator::make(
            $request->all(),
            ['password' => 'required', 'username' => 'required']
        );

        if ($valid->fails()) {
            return [
                'message' => 'All Fields are required',
                'errors' => $valid->errors()->all()
            ];
        }
        $username = $request->username;
        $pass = $request->password;
        $user = false;

        $search = User::where('email', $username)->first();
        if ($search) {
            if (password_verify($pass, $search->password)) {
                $user = $search;
            }
        } else {
            $user =  $this->loginUsername($username, $pass);
        }

        if ($user) {
            Session::forget('admin.redirect');
            Auth::login($user, isset($request->remember));
            return [
                'message' => "Successfully Logged in as $user->username",
                'desc' => 'Time to do something Good',
                'type' => 'success',
                'status' => 200,
                'to' => $this->redirect
            ];
        }

        // log the attempt to faild login attempts
        return [
            'type' => 'error',
            'message' => 'These credentils cannot be found',
            'status' => 200
        ];
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function dashboard()
    {

        return view('admin.pages.dashboard');
    }

    public function tinymce(Request $request)
    {
        if ($request->hasFile('file')) {
            if ($request->file('file')->isValid()) {
                $image = $request->file('file');
                $name = Str::lower(Str::random(10)) . '.' . $image->extension();
                $path =  $image->storeAs('images', $name);

                return ['location' => $path];
            }
        }
    }
}
