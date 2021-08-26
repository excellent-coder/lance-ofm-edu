<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Application Rejected</title>
</head>
<body>
    <div>
        Your application for {{"$app->item $app->applying_for"}} is rejected
        <h1>Reject Reason</h1>
        <p>
            {{$app->reject_reason}}
        </p>
    </div>
</body>
</html>
