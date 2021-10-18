<?php

namespace App\Http\Controllers;

use App\Models\Licence;
use App\Models\Member;
use App\Models\MemberPayment;
use App\Models\Membership;
use App\Models\Publication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $members = Member::latest()->with('membership')->where('active', 1)->take(100)->get();
        $title = 'ACTIVE MEMBERS';
        // return $members;
        return view('admin.pages.members.approved', compact('members', 'title'));
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

    public function addPassword(Member $member)
    {
        if ($member->password) {
            return view('errors.404');
        }
        return view('auth.mem.add-password', compact('member'));
    }

    public function storePassword(Request $request, Member $member)
    {
        if ($member->password) {
            return [
                'status' => 200,
                'type' => 'error',
                'message' => 'something went wrong',
                'to' => '/member'
            ];
        }
        $member->password = bcrypt($request->password);
        $member->save();
        auth('mem')->login($member);
        return [
            'message' => 'Redirecting to dashboard',
            'to' => route('mem'),
            'status' => 200,
            'type' => 'success'
        ];
    }


    public function dashboard()
    {
        return view('frontend.mem.index');
    }

    public function license()
    {
        $licenses = Licence::all();
        return $licenses;
        return view('frontend.mem.licenses.index', compact('licenses'));
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
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function show(Member $member)
    {
        return $member;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function edit(Member $member)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Member $member)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function destroy(Member $member)
    {
        //
    }

    public function publications()
    {
        $pubs = Publication::wherePublished(1)->get();
        $paids = auth('mem')->user()->publications()->get(['id', 'publication_id']); ///->toArray();
        $memPubs = [];
        foreach ($paids as $item) {
            $memPubs[$item->publication_id] = $item->id;
        }
        // return $pubs;
        // return $memPubs;
        return view('frontend.mem.pubs.index', compact('pubs', 'memPubs'));
    }


    public function events()
    {
        $intrests = auth('mem')->user()->eventGoers;
        return view('frontend.mem.events.intrested', compact('intrests'));
    }

    public function licenses()
    {
        $licenses = auth('mem')->user()->licenses;
        return $licenses;
    }

    public function updatePassport(Request $request)
    {
        if ($request->hasFile('passport')) {
            $file = $request->file('passport');
            if ($file->isValid()) {
                $student = auth('mem')->user();

                $name = Str::random(10) . "-" . time()
                    . '.' . $file->getClientOriginalExtension();
                $student->passport = $file->storeAs('members/passports', $name);
                $student->save();

                return ['message' => "Your passport has been updated successfully", 'type' => 'success', 'status' => 200];
            }
        }
        return ['message' => "Something went wrong", 'type' => 'error', 'status' => 200];
    }
}
