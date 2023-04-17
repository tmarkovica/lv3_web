<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <style>
            form {
                display: flex;
                flex-direction: column;
                padding: 200px;
            }
        </style>
    </head>
    <body>
        <form action="/form-login">
            <h2>Login</h2>
            @csrf
            <label for="email"><b>Email</b></label>
            <input type="text" placeholder="Enter Email" name="email" id="email" required>

            <label for="password"><b>Password</b></label>
            <input type="text" placeholder="Enter Password" name="password" id="password" required>

            <button>Login</button>
        </form>

    </body>
</html>
