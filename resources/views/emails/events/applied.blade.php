<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Application for event successfully</title>
</head>
<body>
    <div>
        Hi, {{$goer->name}},
        <P>
            Your application for {{$event->title}}
            Has been successfully.
        </P>
        <p>The event will take place on {{$event->start_at}}</p>
    </div>
</body>
</html>
