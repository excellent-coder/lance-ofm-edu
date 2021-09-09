<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\SCStudent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Program;
use App\Models\ScsPayment;
use App\Models\ScsProgram;

class SCStudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = SCStudent::all();
        // return $students;
        return view('admin.pages.scs.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('apply.scs');
    }

    /**
     * save user application for short course
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function apply(Request $request)
    {
        // return $request->all();

        $valid = Validator::make(
            $request->all(),
            [
                'username' => 'required|unique:s_c_students,username',
                'email' => 'required|unique:s_c_students,email',

                'first_name' => 'required',
                'last_name' => 'required',
                // 'passport' => 'required|file|image|max:20480',
                // 'certificate' => 'required|file|mimes:pdf,docx',

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

        if ($request->hasFile('passport')) {
            $passport = $request->file('passport');
            if ($passport->isValid()) {
                $name =  Str::slug("$request->first_name $request->last_name") . "-" . time()
                    . '.' . $passport->getClientOriginalExtension();
                $s->passport = $passport->storeAs('scs/passports', $name);
            }
        }

        $s->save();

        $payment = new ScsPayment();
        $payment->s_c_student_id = $s->id;
        $payment->amount = web_setting('scs', 'application_fee');
        $payment->currency =  web_setting('general', 'currency');
        $payment->reason = "Application For Short Course Studies";
        $payment->tag = 'application';

        do {
            $ref = 'ISAM-REG-SCS-' . Str::upper(Str::random(10));
        } while (ScsPayment::where('ref', $ref)->first());

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
            'redirect' => route('scs.paid', $payment->id),
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


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SCStudent  $sCStudent
     * @return \Illuminate\Http\Response
     */
    public function show(SCStudent $student)
    {
        $last = SCStudent::latest('id')->first();
        if ($last) {
            $last_matric = $last->matric_no;
        }
        // return $student->allPrograms;
        return view('admin.pages.scs.show', compact('student', 'last_matric'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SCStudent  $sCStudent
     * @return \Illuminate\Http\Response
     */
    public function edit(SCStudent $sCStudent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SCStudent  $sCStudent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SCStudent $student)
    {
        $valid = Validator::make(
            $request->all(),
            ['matric_no' => 'required_if:approved,1']
        );

        if ($valid->fails()) {
            return [
                'message' => 'You have some errors',
                'errors' => $valid->errors()->all()
            ];
        }

        $student->active = $request->filled('active');
        if (!$student->approved_at) {
            if ($request->filled('approved')) {
                $student->approved_at = date('Y-m-d H:i:s');
                $student->matric_no = $request->matric_no;
            }
        }

        $student->save();
        return [
            'message' => 'student updated successfully',
            'type' => 'success',
            'status' => 200,
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SCStudent  $sCStudent
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $ids = trim($request->ids, ',');

        if (empty($ids)) {
            return ['message' => 'nothing to delete'];
        }

        $ids = explode(',', $ids);
        $files = SCStudent::whereIn('id', $ids)->get(['passport', 'certificate']);

        $files->each(function ($file) {
            $p = $file->passport;
            $c = $file->certificate;
            if (file_exists(public_path("storage/$file->passport")) && $p) {
                unlink(public_path("storage/$file->passport"));
            }
            if (file_exists(public_path("storage/$file->certificate")) && $c) {
                unlink(public_path("storage/$file->certificate"));
            }
        });

        $total =  SCStudent::whereIn('id', $ids)->delete();
        if (!$total) {
            return [
                'type' => 'info',
                'message' => 'Unable to excute the delete command',
                'desc' => 'Reload this page and try again'
            ];
        }

        $desc = $total > 1 ? 'Reload this page to see changes' : '';

        return [
            'message' => "$total " . Str::plural('students', $total) . " Deleted successfuly",
            'status' => 200,
            'desc' => $desc
        ];
    }


    public function portal()
    {
        // return auth('scs')->user()->programs;
        return view('frontend.scs.index');
    }

    public function applyProgram()
    {
        $userPrograms = ScsProgram::where('s_c_student_id', auth('scs')->id())
            ->pluck('program_id');
        $programs = Program::where('active', 1)
            ->where('is_program', 1)
            ->where('visibility', '!=', 2)
            ->whereNotIn('id', $userPrograms)
            // ->toSql();
            ->get();
        // return $programs;
        return view('frontend.scs.programs.register', compact('programs'));
    }

    public function updateProgram(Request $request)
    {
        $valid = Validator::make($request->all(), ['programs' => 'required']);

        if ($valid->fails()) {
            return [
                'message' => 'Please choose at least one program',
                'errors' => $valid->errors()->all()
            ];
        }
        foreach ($request->programs as $p) {

            if (ScsProgram::where('s_c_student_id', auth('scs')->id())
                ->whereProgramId($p)->first()
            ) {
                continue;
            }
            $s = new ScsProgram();
            $s->program_id = $p;
            $s->s_c_student_id = auth('scs')->id();
            $s->save();
        }

        return [
            'message' => "You have successfuly registered for the progroams",
            'desc' => ' Login often to check if they have been approved so you can take your lessons',
            'status' => 200,
            'type' => 'success',
            'to' => route('scs')
        ];
    }


    public function program($slug)
    {
        $program = Program::where('slug', $slug)->firstOrFail();
        return view('frontend.scs.programs.courses', compact('program'));
    }

    public function course($course)
    {
        $course = Course::where('slug', $course)->firstOrFail();
        return view('frontend.scs.programs.lessons', compact('course'));
    }

    public function lesson($lesson)
    {
        $lesson = Lesson::where('slug', $lesson)->firstOrFail();
        // return $lesson->load('materials');
        return view('frontend.scs.programs.study', compact('lesson'));
    }
}
