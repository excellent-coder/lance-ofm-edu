<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\State;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class ProfileController extends Controller
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show(Profile $profile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function edit(Profile $profile)
    {
        $profile = Auth::user()->profile;
        // return $profile;
        return view('frontend.portal.profile.edit', compact('profile'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validate_photo = $user->profile ? 'nullable' : 'required';

        $valid = Validator::make(
            $request->all(),
            [
                'first_name' => 'required|max:120',
                'middle_name' => 'nullable|max:120',
                'last_name' => 'required|max:120',
                'photo' => "$validate_photo|image|max:999999",
                'country_id' => 'required',
                'state_id' => 'required',
                'city' => 'required',
                'street' => 'required',
                'phone' =>  "required|max:20"

            ],
            [
                'state_id.required' => 'Please select your state',
                'country_id.required' => 'Please select your country',
                'photo.required' => 'Please choose your profile picture'
            ]
        );

        if ($valid->fails()) {
            return [
                'message' => 'You have some errors',
                'errors' => $valid->errors()->all()
            ];
        }


        if (!$user->profile) {
            $profile = new Profile;
            $profile->user_id = Auth::id();
        } else {
            $profile = $user->profile;
        }
        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $middle_name = $request->middle_name;


        $profile->first_name = $first_name;
        $profile->middle_name = $middle_name;
        $profile->last_name = $last_name;

        $profile->country_id = $request->country_id;
        $profile->state_id = $request->state_id;

        $profile->city = $request->city;
        $profile->street = $request->street;

        $profile->phone = $request->phone;

        // return public_path();

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            if ($file->isValid()) {

                $name = Str::slug("$first_name $last_name") . time()
                    . '.' . $file->extension();
                $profile->photo = $file->storeAs('profiles', $name);
            }
        }

        $profile->save();

        // update user name
        $user->name = "$last_name, $first_name $middle_name";
        $user->save();

        return [
            'status' => 200,
            'message' => 'profile updated successfully',
            'to' => '/portal'
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile)
    {
        //
    }

    public function status()
    {
        $user = Auth::user();
        if ($user->profile) {
            $state = State::find($user->profile->state_id, ['id', 'name']);
            $country = Country::find($user->profile->country_id, ['id', 'name', 'iso2', 'flag']);
            return [
                'profile' => 1,
                'state' => $state,
                'country' => $country
            ];
        }
        return ['profile' => 0];
    }
}
