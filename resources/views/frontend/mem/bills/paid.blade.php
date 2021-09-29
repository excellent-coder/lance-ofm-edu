@extends('layouts.mem')

@section('content')
<div class="container py-4 bg-green-200 bg-opacity-60">
    <div class="w-full my-4">
        <h1 class="my-4 text-xl font-black text-center text-black uppercase">Your transactions</h1>
        <table class="w-full border border-collapse border-blue-600 table-fixed table-bordered">
          <thead>
            <tr>
              <th class="w-1/12 px-4 py-1 border border-blue-600">#</th>
              <th class="px-4 py-1 border border-blue-600" style="width:10%;">Amount</th>
              <th class="w-1/6 px-4 py-1 border border-blue-600">Date</th>
              <th class="w-1/4 px-4 py-1 border border-blue-600">Reason</th>
              <th class="px-4 py-1 border border-blue-600 w-1/7">status</th>
            </tr>
          </thead>
          <tbody>
              <?php $i=1 ?>
            @foreach ($auth->payments as $pay)
            <tr class="border-blue-600">
                <td class="px-4 py-1 border border-blue-600">{{$i++}}</td>
                <td class="px-4 py-1 border border-blue-600">{{$pay->amount}}</td>
                <td class="px-4 py-1 border border-blue-600">{{$pay->updated_at}}</td>
                <td class="px-4 py-1 border border-blue-600">{{$pay->reason}}</td>
                <td class="px-4 py-1 border border-blue-600">{{$pay->status}}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
    </div>
</div>
@endsection
