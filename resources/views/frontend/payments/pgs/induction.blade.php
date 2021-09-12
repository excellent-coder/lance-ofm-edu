@extends('layouts.auth')
@section('content')
<div class="container mt-8 ">
    <h1>
        Hey, {{$student->name}}
        <br>
        click the button below to make payment
    </h1>
    <div class="flex flex-wrap justify-center">
        <table style="border: 2px solid black; padding:10px; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="
                    border: 2px solid black;
                    padding:10px;
                    background-color: #601edb;
                    color: white;">Item</th>
                    <th style=" border: 2px solid black;
                    padding:10px;
                    background-color: #601edb;
                    color: white;">Price</th>
                </tr>
            </thead>
            <tbody>
                @php
                $acceptance = web_setting('pgs', 'acceptance_fee');
                $matric = web_setting('pgs', 'matriculation_fee');
                $idCard = web_setting('pgs', 'id_card_fee');
                $handBook = web_setting('pgs', 'student_handbook_fee');
                $devLevy =web_setting('pgs', 'development_levy');
                $tuition=web_setting('pgs', 'tuition_fee');
                $total = array_sum([$acceptance,$matric,$idCard,$handBook, $devLevy, $tuition]);
                @endphp
                <tr>
                    <th style="border: 2px solid black; padding: 5px;">Acceptance Fee</th>
                    <td style="border: 2px solid black; padding: 5px;">{{$acceptance }}</td>
                </tr>
                <tr>
                    <th style="border: 2px solid black; padding: 5px;">Matriculation Fee</th>
                    <td style="border: 2px solid black; padding: 5px;">{{$matric}}</td>
                </tr>
                <tr>
                    <th style="border: 2px solid black; padding: 5px;">Id Card Fee</th>
                    <td style="border: 2px solid black; padding: 5px;">{{$idCard}}</td>
                </tr>
                <tr>
                    <th style="border: 2px solid black; padding: 5px;">Student Handbook</th>
                    <td style="border: 2px solid black; padding: 5px;">{{$handBook}}</td>
                </tr>
                <tr>
                    <th style="border: 2px solid black; padding: 5px;">Development Levy</th>
                    <td style="border: 2px solid black; padding: 5px;">{{$devLevy}}</td>
                </tr>
                <tr>
                    <th style="border: 2px solid black; padding: 5px;">Tuition</th>
                    <td style="border: 2px solid black; padding: 5px;">{{$tuition}}</td>
                </tr>
                <tr>
                    <th style="border: 2px solid black; padding: 5px;">Total</th>
                    <td style="border: 2px solid black; padding: 5px;"><b>{{$currency}} {{number_format($total, 2)}} </b>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="w-full mt-5 text-center">
            <form action="{{route('payment.pgs.induction', $student->id)}}" method="post" @submit.prevent="submit($event)">
        <button type="submit"
            class="w-32 px-4 py-3 antialiased font-semibold text-center text-white transition-all bg-indigo-900 border-2 border-gray-100 rounded-lg shadow-xl hover:bg-yellow-500">
            Pay
        </button>
            </form>
        </div>
    </div>
</div>
@endsection
