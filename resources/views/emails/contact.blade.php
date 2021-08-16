<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>FROM {{"$contact->first_name $contact->last_name"}}</title>
</head>
<body>
<div>
    <table>
        <tbody>
            <td>
                <h1>
                    <strong>
                        New Contact Message FROM
                    </strong>
                </h1>
                <h1>
                    <strong>
                        {{"$contact->first_name $contact->last_name"}}
                    </strong>
                </h1>
                <h1>{{$contact->email}}</h1>
                <h1>{{$contact->phone}}</h1>
            </td>
            <td style="font-weight:900; margin-top: 50px; margin-bottom: 50px; text-align: left; backgroud-color: rgb(237, 248, 248)">
                {{ $contact->message }}
            </td>
        </tbody>
    </table>
</div>
</body>
</html>
