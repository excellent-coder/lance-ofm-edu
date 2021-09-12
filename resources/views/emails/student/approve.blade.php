<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>YourRequest to study {{$student->program->title}}</title>
    <style>
        * {
            box-sizing: border-box;
        }

    </style>
</head>

<body>
    @if ($student->approved_at)
    <div style="width:100%; display:flex; justify-content:center; flex-wrap:wrap;">
        <p style="width: 100%; text-align:center;">
            Your Application request to study {{$student->program->title}}
            has been approved
        </p>
        <p style="width: 100%; text-align:center;">
            Use the link below to make payment to validate your studentship
        </p>
    </div>
    <div style="width:100%; display:flex; justify-content:center; flex-wrap:wrap;">
    <h1 style="width: 100%; text-align:center; font-weight:900; margin:1rem 0;">Invoice</h1>
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
                    color: white;">({{$currency}}) FEE</th>
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
                    <td style="border: 2px solid black; padding: 5px;"><b>{{$currency}} {{number_format($total)}} </b>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <P style="width:100%; display:flex; justify-content:center; flex-wrap:wrap;">
        <a style="background-color:green; color:white; padding:10px; text-decoration:none;"
            href="{{route('payment.pgs.induction', $student->id)}}" target="_blank">
            Make Payment
        </a>
    </P>
    @else
    <h1>
        Your Request to study {{$student->program->title}} was rejected
        <h1>Because</h1>
        <p>
            {{$student->reject_reason}}
        </p>
    </h1>
    @endif
</body>

</html>
