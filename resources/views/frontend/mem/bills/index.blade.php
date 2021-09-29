@extends('layouts.mem')

@section('content')
<div class="container py-4 bg-green-200 bg-opacity-60">
    <div class="w-full my-4">
        <h1 class="my-4 text-xl font-black text-center text-black uppercase">Bills</h1>
        <table class="w-full border border-collapse border-blue-600 table-auto table-bordered">
          <thead>
            <tr>
              <th class="w-1/3 px-4 py-1 border border-blue-600">Bill</th>
              <th class="w-1/3 px-4 py-1 border border-blue-600">Amount</th>
              <th class="w-1/3 px-4 py-1 border border-blue-600">status</th>
            </tr>
          </thead>
          <tbody>
            <tr class="border-blue-600">
                <td class="px-4 py-1 border border-blue-600">Membership Induction</td>
                <td class="px-4 py-1 border border-blue-600">{{$auth->membership->application_fee}}</td>
                <td class="px-4 py-1 border border-blue-600">Paid</td>
            </tr>
            <tr class="border-blue-600">
                <td class="px-4 py-1 border border-blue-600">Membership Annual Dues</td>
                <td class="px-4 py-1 border border-blue-600">{{$auth->membership->annual_fee}}</td>
                @php
                    if(date('Y') == $auth->created_at->format('Y')){
                        $paid = "You will start paying annula dues from ". date('Y-m-d', strtotime("1st January Next Year"));
                    }else{
                     $paid =   $auth->paidAnnual?'Paid':'Pending';
                    }
                @endphp
                <td class="px-4 py-1 border border-blue-600">{{$paid;}}</td>
            </tr>
          </tbody>
        </table>
    </div>
</div>
@endsection
