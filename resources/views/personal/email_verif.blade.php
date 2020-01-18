<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email Confirmation</title>
    <style>
        body {
            padding: 5px;
            width: 700px;
            margin: 0px auto
        }
        .link{
            background: purple;
            color: white !important;
            padding: 10px;
            text-decoration: none;
            font-size: 20px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <p>Hi, {{  $user['name'] }} , I`m From Ayo Sekolah</p>
    <h2>
        Please,Confirmation Account with Email
    </h2>
    <a class="link" href="{{ route('personal.register.confirm',['token' => $dataLogin['token']]) }}">Confirmation</a>
    <p>Thanks You.</p>
</body>
</html>