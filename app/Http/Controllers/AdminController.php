<?php

namespace App\Http\Controllers;

use DocuSign\eSign\Model\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminController extends Controller
{

    public function login()
    {
        return view('admin.pages.login');
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
