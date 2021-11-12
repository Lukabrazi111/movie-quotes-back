<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset("css/app.css") }}">
    <title>Movie Quote</title>
</head>
<body>

@if(session('success'))
    <div class="py-4 px-6 w-full max-w-2xl text-center m-auto mt-4 bg-green-300 text-black rounded bg-opacity-60">
        <p class="text-xl text-">{{ session('success') }}</p>
    </div>
@endif

@if(session('error'))
    <div class="py-4 px-6 w-full max-w-2xl text-center m-auto mt-4 bg-red-400 text-black rounded bg-opacity-60">
        <p class="text-xl text-">{{ session('error') }}</p>
    </div>
@endif

@yield('content')
</body>
</html>
