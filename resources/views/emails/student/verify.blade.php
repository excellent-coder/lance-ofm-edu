<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verify Your Email</title>
</head>
<body>
    <p>
        Your Application request to study {{$ap->program->title}}
        has been received and you will be notified once it is reviewed
    </p>
    <p>
        Click the link below to verify your email
    </p>
    <p>
        <a href="{{route('pgs.verify', ['id'=>$ap->id, 'email'=>$ap->email])}}" target="_blank">
            Verify
        </a>

    </p>
    <p>
        Unable to clik the link above, copy the link below and paste in your browser
    </p>
    <p>
        <a href="{{route('pgs.verify', ['id'=>$ap->id, 'email'=>$ap->email])}}" target="_blank">
            {{route('pgs.verify', ['id'=>$ap->id, 'email'=>$ap->email])}}
        </a>
    </p>
</body>
</html>
