<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $data['title'] }}</title>
</head>

<body>
    <p>
        hey <b>{{ $data['name'] }}</b>, welcome to refferel system.
    </p>
    <p> <b>User Name:</b>{{ $data['name'] }}</p>
    <p><b>Password:</b>{{ $data['password'] }}</p>
    <p>
        YOU can add user to your network by share <a href="{{ $data['url'] }}">referrel_link</a>
        .Don't share your password with others
    </p>
    <p>Thank You</p>

</body>

</html>
