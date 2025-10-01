<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Reset password email</title>
    <style>
        * {
            font-family: "Helvetica Neue", sans-serif;
            font-weight: 300;
        }

        body {
            background-color: #181623;
            margin: 4rem 0;
            color: white;
        }
    </style>
</head>
<body>
<div class="w-full max-w-5xl mx-auto">
    <div class="flex items-center flex-col justify-center space-y-4">
        <img src="{{asset('images/chat-quote.png')}}" alt="chat-quote">
        <h3 class="uppercase text-lg text-[#DDCCAA]">Movie quotes</h3>
    </div>

    <div class="mt-20 flex flex-col items-start space-y-5">
        <h1>Hola {{ $name }}</h1>

        <p>Hey, please click the button below for reset your password:</p>

        <a href="{{ route('reset-password', $token) }}" class="bg-[#E31221] hover:bg-[#CC0E10] text-white px-3 py-1.5 rounded">
            Reset password
        </a>

        <p>If clicking doesn't work, you can try copying and pasting it to your browser:</p>

        <a href="{{ route('reset-password', $token) }}" class="text-[#DDCCAA]">
            {{ route('reset-password', $token) }}
        </a>

        <p>If you have any problems, please contact us: support@examplemoviequotes.com</p>

        <p>MovieQuotes Crew</p>

    </div>
</div>
</body>
</html>
