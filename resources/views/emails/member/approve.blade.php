<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Your Request For {{$member->membership->name}}</title>
    <style>
        * {
            box-sizing: border-box;
        }

    </style>
</head>

<body>
    @if ($member->approved_at)
    <div style="width:100%; display:flex; justify-content:center; flex-wrap:wrap;">
        <p style="width: 100%; text-align:center;">
            Your Application request {{$member->membership->name}}
            has been approved
        </p>
        <p style="width: 100%; text-align:center;">
            Use the link below to make payment to validate your Membership
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
                <tr>
                    <th style="border: 2px solid black; padding: 5px;">
                        Acceptance Fee
                    </th>
                    <td style="border: 2px solid black; padding: 5px;">
                        {{$member->membership->application_fee }}
                    </td>
                </tr>
                <tr>
                    <th style="border: 2px solid black; padding: 5px;">Total</th>
                    <td style="border: 2px solid black; padding: 5px;">
                        <b>
                            {{$currency}}
                            {{number_format($member->membership->application_fee)}}
                        </b>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <P style="width:100%; display:flex; justify-content:center; flex-wrap:wrap;">
        <a style="background-color:green; color:white; padding:10px; text-decoration:none;"
            href="{{route('payment.mem.induction', $member->id)}}" target="_blank">
            Make Payment
        </a>
    </P>
    @else
    <h1>
        Your Request to study {{$member->program->title}} was rejected
    </h1>
        <h1>Because</h1>
        <p>
            {{$member->reject_reason}}
        </p>
        <p>
            If you believe the reject was made in a error
            click the link below to re Apply
        </p>
       <P style="width:100%; display:flex; justify-content:center; flex-wrap:wrap;">
        <a style="background-color:green; color:white; padding:10px; text-decoration:none;"
            href="{{route('mem.appeal', $member->id)}}" target="_blank">
           Make  Appeal
        </a>
    </P>
    @endif
</body>

</html>
