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
                <h1>New Contact Message fROM</h1>
                <h1>{{"$contact->first_name $contact->last_name"}}</h1>
                <h1>{{$contact->phone}}</h1>
                <h1>{{$contact->phone}}</h1>
            </td>
            <td>
                {{ $contact->message }}
            </td>
        </tbody>
    </table>
</div>
</body>
</html>
