<?php

namespace App\Http\Controllers;

use App\Models\StudentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Application;
use Illuminate\Support\Str;
use App\Models\Course;
use App\Models\Lesson;
use App\Mail\AdminApplied;
use App\Mail\Applied;
use App\Mail\StudentApproved;
use App\Mail\StudentVerifyEmail;
use App\Models\Program;
use App\Models\Student;
use Exception;
use Illuminate\Support\Facades\Mail;
use stdClass;

class StudentRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $apps = StudentRequest::where('reviewed', 0)->get();
        $title = "Applicants for main student";
        return view('admin.pages.applications.students', compact('apps', 'title'));
    }

    public function approved()
    {
        $students = Student::latest('id')->get();
        $title = "Approved Students";
        return view('admin.pages.students.approved', compact('students', 'title'));
    }

    public function pending()
    {
        $students = StudentRequest::where('reviewed', 0)->get();
        $title = "Applicants for main student";
        return view('admin.pages.students.pending', compact('students', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $programs = Program::whereActive('1')
            ->where('visibility', '<', '3')
            ->whereIsProgram('1')
            ->get();
        // return $programs;
        return view('apply.student', compact('programs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $valid = Validator::make(
            $request->all(),
            [
                'program' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
                'dob' => 'required',
                'phone' => 'required',
                'email' => 'required',
                // 'passport' => 'required|image',
                'terms' => 'required',
                // 'certificates' => 'required|file'
            ],
            [
                'terms.required' => 'You must agree to our terms To apply',
            ]
        );

        if ($valid->fails()) {
            return [
                'message' => 'You have some errors',
                'errors' => $valid->errors()->all()
            ];
        }
        // return $request->all();

        $applied = StudentRequest::where('email', $request->email)
            ->whereNull('rejected_at')
            ->where('program_id', $request->program)
            ->first();

        if ($applied) {
            return [
                'message' => "You have already applied for this program",
                'type' => 'info',
                'desc' => "You will be contacted via $applied->email Once the status
                            of your request is updated",
                'timeout' => 400000
            ];
        }

        $app = new StudentRequest();

        $app->first_name = $request->first_name;
        $app->last_name = $request->last_name;
        $app->middle_name = $request->middle_name;
        $app->dob = $request->dob;
        $app->phone = $request->phone;
        $app->email = $request->email;
        $app->program_id = $request->program;

        if ($request->hasFile('certificates')) {
            $certs = $request->file('certificates');
            $certName = [];
            foreach ($certs as $cert) {
                if ($cert->isValid()) {

                    $name =  Str::upper(Str::slug("$request->first_name $request->last_name"))
                        . '-APP-CERT-' . time() . '.' . $cert->getClientOriginalExtension();
                    $certName[] = $cert->storeAs(
                        "$request->applying_for/certificates",
                        $name
                    );
                }
            }
            $app->certificates = implode(',', $certName);
        }

        if ($request->hasFile('documents')) {
            $docs = $request->file('documents');
            $docName = [];
            foreach ($docs as $d) {
                if ($d->isValid()) {
                    $name = Str::slug("$request->first_name $request->last_name")
                        . '-' . time()
                        . $d->getClientOriginalName();

                    $docName[] = $d->storeAs(
                        "$request->applying_for/documents",
                        $name
                    );
                }
            }

            $app->documents = implode(',', $docName);
        }

        if ($request->hasFile('passport')) {
            $passport = $request->file('passport');
            if ($passport->isValid()) {
                $name =  Str::slug("$request->first_name $request->last_name") . "-" . time()
                    . '.' . $passport->getClientOriginalExtension();
                $app->passport = $passport->storeAs("$request->applying_for/passports", $name);
            }
        }

        $app->save();

        try {
            Mail::send(new StudentVerifyEmail($app));
        } catch (Exception $e) {
        }

        return [
            'status' => 200,
            'message' => 'Your application has been submitted successfully',
            'desc' => 'You will be contacted via email',
            'type' => 'success',
            'link' => route('pgs.verify', ['id' => $app->id, 'email' => $app->email])
        ];
    }

    public function verifyEmail($id, $email)
    {
        $app = StudentRequest::whereEmail($email)->whereId($id)->firstOrFail();
        if (!$app->email_verified_at) {
            $app->email_verified_at = date('Y-m-d H:i:s');
            $app->save();
        }
        $data = new stdClass();
        $data->message = "$app->first_name $app->last_name You have successfully verified your email $app->email"
            . "Check Your email often for email from Isam for an email about your confirmation";
        return view('auth.verified', compact('data'));
    }

    public function approve(Request $request, StudentRequest $student)
    {
        $valid = Validator::make($request->all(), [
            'reject_reason' => 'required_if:reject,true',
        ]);

        if ($valid->fails()) {
            return [
                'message' => 'You have some errors',
                'errors' => $valid->errors()->all()
            ];
        }
        // return $request->all();

        $date = date('Y-m-d H:i:s');
        $student->approved_at = $request->filled('approve') ? $date : null;
        $student->rejected_at = $request->filled('reject') ? $date : null;
        $student->reviewed = $request->filled('reviewed');

        if ($student->approved_at) {
            // message student for payment
            $student->save();
            try {
                Mail::send(new StudentApproved($student));
            } catch (Exception $e) {
            }
            return [
                'status' => 200,
                'message' => 'You have successfully Approved this student',
                'desc' => "an email has been sent to $student->email",
                'type' => 'success',
                'link' => route('payment.pgs.induction', $student->id)
            ];
        } elseif ($student->rejected_at) {
            $student->reject_reason = $request->reject_reason;
            $student->save();
            try {
                Mail::send(new StudentApproved($student));
            } catch (Exception $e) {
            }
            return [
                'status' => 200,
                'message' => 'You have successfully rejected this student request',
                'desc' => "an email has been sent to $student->email",
                'type' => 'info'
            ];
            // message student about rejection
        }
        $student->save();
        if ($student->reviewed) {
            return [
                'status' => 200,
                'message' => 'You have successfully reviewed this student request',
                'type' => 'info'
            ];
        }
        return [
            'status' => 200,
            'message' => 'Update Successfully',
            'type' => 'info'
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StudentRequest  $studentRequest
     * @return \Illuminate\Http\Response
     */
    public function show(StudentRequest $studentRequest)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StudentRequest  $studentRequest
     * @return \Illuminate\Http\Response
     */
    public function edit(StudentRequest $studentRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StudentRequest  $studentRequest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StudentRequest $studentRequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StudentRequest  $studentRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $ids = trim($request->ids, ',');

        if (empty($ids)) {
            return ['message' => 'nothing to delete'];
        }

        $ids = explode(',', $ids);
        $files = StudentRequest::whereIn('id', $ids)->get(['passport', 'certificates', 'documents']);

        $files->each(function ($file) {
            if (file_exists(public_path("storage/$file->passport")) && $file->passport) {
                unlink(public_path("storage/$file->passport"));
            }
        });

        $total =  StudentRequest::whereIn('id', $ids)->delete();
        if (!$total) {
            return [
                'type' => 'info',
                'message' => 'Unable to excute the delete command',
                'desc' => 'Reload this page and try again'
            ];
        }

        $desc = $total > 1 ? 'Reload this page to see changes' : '';

        return [
            'message' => "$total " . Str::plural('Applicant', $total) . " Deleted successfuly",
            'status' => 200,
            'desc' => $desc
        ];
    }
}
