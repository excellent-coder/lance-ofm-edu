@extends('layouts.mem')

@section('content')
<div class="container py-4 bg-green-200 bg-opacity-60">
    <div class="w-full my-4">
        <h1 class="my-4 text-xl font-black text-center text-black uppercase">Outstanding Bills</h1>
        <table class="w-full border border-collapse border-blue-600 table-auto table-bordered">
          <thead>
            <tr>
              <th class="w-1/3 px-4 py-1 border border-blue-600">#</th>
              <th class="w-1/3 px-4 py-1 border border-blue-600">Bill</th>
              <th class="w-1/3 px-4 py-1 border border-blue-600">Amount</th>
              <th class="w-1/3 px-4 py-1 border border-blue-600">Pay</th>
            </tr>
          </thead>
          <tbody>
              <?php $i=1;?>
              @foreach ($bills as $bill)
              <tr class="border-blue-600">
                  <td class="px-4 py-1 border border-blue-600">{{$i++}}</td>
                  <td class="px-4 py-1 border border-blue-600">{{$bill['name']}}</td>
                  <td class="px-4 py-1 border border-blue-600">{{$bill['amount']}}</td>
                  <td class="px-4 py-1 border border-blue-600">
                    <button @click.prevent="memberPayment({{collect($bill)}})" class="inline-block p-2 bg-blue-500 border-2 border-opacity-75 bg-opacity-30">
                        Pay Now
                    </button>
                    </td>
              </tr>
              @endforeach
          </tbody>
        </table>
    </div>
</div>

<modal title="Make Payment" btn-txt="Donate" id="payment-modal">
    <template v-slot:body>
        <div>
            Welcome to our school
            <p>Make a donation to the bank details below</p>
            <p>We sincerly appreciate your donation</p>
        </div>
    </template>
</modal>
@endsection
