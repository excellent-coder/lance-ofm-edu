<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MemberBillController extends Controller
{
    public function bills()
    {
        $bills = collect();
        // return auth('mem')->user()->membership;
        // return auth('mem')->user();

        return view('frontend.mem.bills.index');
    }

    public function paid()
    {
        return view('frontend.mem.bills.paid');
    }

    public function pending()
    {
        $vills = [];
        $user = auth('mem')->user();
        // $iten  = []
        if ($user->created_at->format('Y') == date('Y')) {
            $anual = auth('mem')->user()->paidAnnual;
            if (!$anual) {
                $bills[] = ['name' => 'Anual Dues', 'amount' => $user->membership->annual_fee, 'route' => 'mem.pay.annual'];
            }
        }

        return view('frontend.mem.bills.pending', compact('bills'));
    }
}
