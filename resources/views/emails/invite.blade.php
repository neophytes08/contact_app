<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <p>Hello,</p>
    <p>User {{ ucwords($user->name) }} invited you to create an account and add as his contact.</p>
    <p>Please click <a href="{{ $user->url }}">here</a> to create an account</p>
</body>
</html>