@extends('layouts.admin-layout')

<div class="mt-9 text-center">
    <a href="/" class="text-white py-2 px-4 bg-gray-500 rounded hover:bg-gray-700 transition delay-75">Go
        Back</a>
</div>

@section('content')
    {{-- Check session with error message --}}
    @if(session()->get('success'))
        <div class="py-4 px-6 w-full max-w-2xl text-center m-auto mt-4 bg-red-300 text-black rounded bg-opacity-60">
            <p class="text-xl text-">{{ session('success') }}</p>
        </div>
    @endif

    <div class="bg-gray-400 rounded p-10 w-1/2 flex flex-col justify-center items-center m-auto mt-6">

        <div class="text-center">
            <p class="text-xl text-gray-900">Login</p>
        </div>

        {{-- Edit Form --}}
        {!! Form::open(['action' => 'App\Http\Controllers\UserAuthController@store', 'method' => 'POST', 'class' => 'flex flex-col p-2 m-2']) !!}

        {{ Form::label('email', 'Email', ['class' => 'mb-2']) }}
        {{ Form::email('email', null, ['class' => 'p-2 border border-primary rounded mb-2 outline-none bg-indigo-50']) }}

        {{ Form::label('password', 'Password', ['class' => 'mb-2']) }}
        {{ Form::password('password', ['class' => 'p-2 border border-primary rounded mb-2 outline-none bg-indigo-50']) }}

        {{ Form::submit('Login', ['class' => 'text-center text-white mt-3 bg-gray-700 rounded px-4 py-2 hover:bg-gray-600 transition cursor-pointer']) }}

        {!! Form::close() !!}
    </div>

@endsection
