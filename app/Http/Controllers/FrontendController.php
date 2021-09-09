<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function dashboard()
    {
        foreach (['pgs', 'scs', 'mem'] as $g) {
            if ($a = auth($g)->user()) {
                return view("frontend.$g.index");
            }
        }
    }
}
