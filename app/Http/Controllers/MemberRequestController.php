<?php

namespace App\Http\Controllers;

use App\Models\MemberRequest;
use Illuminate\Http\Request;
use App\Models\Membership;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use stdClass;
use App\Mail\MemberVerifyEmail;
use App\Models\Member;
use Exception;
use App\Mail\MemberApproved;

// use


class MemberRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function approved()
    {
        $members = Member::latest('id')->get();
        // return $members;
        $title = "Approved Members";
        return view('admin.pages.members.approved', compact('members', 'title'));
    }

    public function pending()
    {
        $members = MemberRequest::where('reviewed', 0)->get();
        $title = "Applicants for members";
        return view('admin.pages.members.pending', compact('members', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $memberships = Membership::whereActive('1')->where('parent_id', null)->get();
        // return $memberships;
        return view('apply.member', compact('memberships'));
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
                'membership' => 'required',
                'sub_membership' => 'required_if:sub,1',
                'first_name' => 'required',
                'last_name' => 'required',
                'dob' => 'required',
                'phone' => 'required',
                'email' => 'required',
                // 'passport' => 'required|image',
                'terms' => 'required',
                // 'certificates' => 'required|file',
                // 'pay' => 'required'
            ],
            [
                'terms.required' => 'You must agree to our terms To apply',
                'sub_membership.required_if' => 'Sub membership is Required'
            ]
        );

        if ($valid->fails()) {
            return [
                'message' => 'You have some errors',
                'errors' => $valid->errors()->all()
            ];
        }
        // return $request->all();

        $applied = MemberRequest::where('email', $request->email)
            ->whereNull('rejected_at')
            ->where('membership_id', $request->membership)
            ->first();

        if ($applied) {
            return [
                'message' => "You have already applied for this Membership",
                'type' => 'info',
                'desc' => "You will be contacted via $applied->email Once the status
                            of your request is updated",
                'timeout' => 400000
            ];
        }

        $app = new MemberRequest();

        $app->first_name = $request->first_name;
        $app->last_name = $request->last_name;
        $app->middle_name = $request->middle_name;

        $mem_id = $request->membership;
        if ($request->filled('sub_membership')) {
            $mem_id = $request->sub_membership;
        }

        $app->dob = date('Y-m-d', strtotime($request->dob));

        $app->phone = $request->phone;
        $app->email = $request->email;
        $app->membership_id = $mem_id;

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
        $verify = '';
        try {
            Mail::send(new MemberVerifyEmail($app));
        } catch (Exception $e) {
            $verify = route('mem.verify', ['id' => $app->id, 'email' => $app->email]);
            // return $e->getMessage();
        }

        return [
            'status' => 200,
            'message' => 'Your application has been submitted successfully',
            'desc' => "Check your inbox for an email verification request",
            'verify' => $verify,
            'type' => 'success'
        ];
    }

    public function verifyEmail($id, $email)
    {
        $app = MemberRequest::whereEmail($email)->whereId($id)->firstOrFail();
        if (!$app->email_verified_at) {
            $app->email_verified_at = date('Y-m-d H:i:s');
            $app->save();
        }
        $data = new stdClass();
        $data->message = "$app->first_name $app->last_name
        You have successfully verified your email $app->email
         Check Your email often for email from Isam
         for an email about your confirmation";

        return view('auth.verified', compact('data'));
    }

    public function approve(Request $request, MemberRequest $member)
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
        $member->approved_at = $request->filled('approve') ? $date : null;
        $member->rejected_at = $request->filled('reject') ? $date : null;
        $member->reviewed = $request->filled('reviewed');

        if ($member->approved_at) {
            // message student for payment
            $member->save();
            try {
                Mail::send(new MemberApproved($member));
            } catch (Exception $e) {
            }
            return [
                'status' => 200,
                'message' => 'You have successfully Approved this student',
                'desc' => "an email has been sent to $member->email",
                'link' => route('payment.mem.induction', $member->id),
                'type' => 'success',
            ];
        } elseif ($member->rejected_at) {
            $member->reject_reason = $request->reject_reason;
            $member->save();
            try {
                Mail::send(new MemberApproved($member));
            } catch (Exception $e) {
            }
            return [
                'status' => 200,
                'message' => 'You have successfully rejected this student request',
                'desc' => "an email has been sent to $member->email",
                'type' => 'info',
                'link' => route('mem.appeal', $member->id)
            ];
            // message student about rejection
        }
        $member->save();
        if ($member->reviewed) {
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
     * @param  \App\Models\MemberRequest  $memberRequest
     * @return \Illuminate\Http\Response
     */
    public function show(MemberRequest $memberRequest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MemberRequest  $memberRequest
     * @return \Illuminate\Http\Response
     */
    public function edit(MemberRequest $memberRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MemberRequest  $memberRequest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MemberRequest $memberRequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MemberRequest  $memberRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $ids = trim($request->ids, ',');

        if (empty($ids)) {
            return ['message' => 'nothing to delete'];
        }

        $ids = explode(',', $ids);
        $files = MemberRequest::whereIn('id', $ids)
            ->get(['passport', 'certificates', 'documents']);

        $files->each(function ($file) {
            if (file_exists(public_path("storage/$file->passport")) && $file->passport) {
                unlink(public_path("storage/$file->passport"));
            }
        });

        $total =  MemberRequest::whereIn('id', $ids)->delete();
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
