<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Approved</title>
</head>
<body>
    <div>
        <h1>Application approved</h1>
        <p>
            Your application for {{"$app->item  $app->applying_for"}} has been approved
            Login with the detaisl below
        </p>

        <p>
            <b>Username: </b> {{$login->id}}
        </p>
        <p>
            <b>Password: </b> {{$login->password}}
        </p>
    </div>
</body>
</html>
