<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Payment;
use App\Models\Profile;
use App\Models\SCStudent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use App\Models\Student;


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
        // return $request->all();

        $valid = Validator::make(
            $request->all(),
            [
                'username' => 'required|unique:s_c_students,username',
                'email' => 'required|unique:s_c_students,email',

                'first_name' => 'required',
                'last_name' => 'required',
                'passport' => 'required|file|image|max:20480',
                'certificate' => 'required|file|mimes:pdf,docx',

                'dob' => 'required',
                'terms' => 'required',
                'pay' => 'required',
                'phone' => 'required',
                'password' => 'required|min:8|max:16',
            ],
            [
                'terms.required' => 'You must agree to our terms',
                'pay.required' => 'You must be ready to make payment of application fee before registration'
            ]
        );

        if ($valid->fails()) {
            return [
                'message' => 'You have some Errors',
                'errors' => $valid->errors()->all()
            ];
        }

        // return ['--'];
        $s = new SCStudent();

        $s->username = $request->username;
        $s->email = $request->email;

        $s->first_name = $request->first_name;
        $s->last_name = $request->last_name;
        $s->middle_name = $request->middle_name;

        $s->phone = $request->phone;
        $s->dob = $request->dob;

        $s->password = bcrypt($request->password);
        $s->device = $request->device;
        $s->ip = $request->ip();

        // saving form;
        if ($request->hasFile('certificate')) {
            $cert = $request->file('certificate');
            if ($cert->isValid()) {

                $name =  Str::upper(Str::slug("$request->first_name $request->last_name"))
                    . '-SCS-CERT-' . time() . '-.' . $cert->getClientOriginalExtension();
                $s->certificate = $cert->storeAs(
                    "scs/certificates",
                    $name
                );
            } else {
                return [
                    'message' => "Please upload avalid certificate",
                    'type' => 'error',
                    'status' => 200
                ];
            }
        }

        // saving documents
        if ($request->hasFile('documents')) {
            $docs = $request->file('documents');
            $docName = [];
            foreach ($docs as $d) {
                if ($d->isValid()) {
                    $name = Str::slug("$request->last_name")
                        . '-' . time() . '-'
                        . $d->getClientOriginalName();

                    $docName[] = $d->storeAs(
                        "scs/documents",
                        $name
                    );
                }
            }

            $s->documents = implode(',', $docName);
        }

        $passport = $request->file('passport');
        if ($passport->isValid()) {

            $name =  Str::slug("$request->first_name $request->last_name") . "-" . time()
                . '.' . $passport->getClientOriginalExtension();
            $s->passport = $passport->storeAs('members/passports', $name);
        }

        $s->save();

        $payment = new Payment();
        $payment->user_id = $s->id;
        $payment->guard = 's_c_students';
        $payment->amount = web_setting('scs', 'application_fee');
        $payment->currency =  web_setting('general', 'currency');
        $payment->reason = 'scs application';

        do {
            $ref = 'ISAM-REG-SCS-' . Str::upper(Str::random(10));
        } while (Payment::where('ref', $ref)->first());

        $payment->ref = $ref;
        $payment->ip = $request->ip();
        $mac = exec('getmac');
        $payment->mac = strtok($mac, ' ');
        $payment->device = $request->devce;

        $payment->save();

        $p = [
            'public_key' => config('services.rave.public_key'),
            'ref' => $ref,
            'amount' => $payment->amount,
            'currency' => $payment->currency,
            'country' => config('msc.country', 'NG'),
            'redirect' => route('payment.validate', $payment->id),
            'meta' => ['consumer_id' => $s->id, 'consumer_mac' => $mac],
            'customer' => [
                'email' => $request->email,
                'phone_number' => $request->phone,
                'reason' => $payment->reason,
                'user_id' => $s->id,
                'name' => "$request->last_name $request->first_name",
            ],
            'customization' => [
                'title' => web_setting('scs', 'payment_title', 'Title'),
                'description' => web_setting('scs', 'payment_desc', 'Description'),
                'logo' => asset('storage/' . web_setting('general', 'logo', 'web/logo.png'))
            ],
        ];

        Auth::guard('scs')->login($s);
        return [
            'message' => "First Step completed",
            'desc' => 'Make payment to complete your registration',
            'type' => 'success',
            'status' => 200,
            'payment' => $p,
            // 'to' => '/scs'
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
                    'to' => '/member',
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
                    'to' => '/portal',
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
