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
<body class="bg-primary">

<div class="flex justify-center items-center mt-6">
    @if(auth()->check())
        <a href="{{ route('admin.show') }}" class="text-white hover:underline mr-4">Admin Panel</a>
        <a href="{{ route('user.logout') }}" class="text-white hover:underline mr-4">Logout</a>
    @else
        <a href="{{ route('user.index') }}" class="text-white hover:underline">Login</a>
    @endif
</div>


@yield('content')

{{-- Languages --}}
<div class="fixed top-1/2 ml-10 flex items-center justify-center flex-col gap-2">
    <a href="#" class="text-white w-12 text-center hover:text-black hover:bg-white border p-3 rounded-full">en</a>
    <a href="#" class="text-white text-center w-12 hover:text-black hover:bg-white border p-3 rounded-full">ka</a>
</div>

</body>
</html>
