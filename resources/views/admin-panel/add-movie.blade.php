@extends('layouts.admin-layout')

<div class="mt-9 text-center">
    <a href="{{ route('admin.show') }}" class="text-white py-2 px-4 bg-gray-500 rounded hover:bg-gray-700 transition delay-75">Go
        Back</a>
</div>

@section('content')
    <div class="bg-gray-400 rounded p-10 w-auto max-w-2xl flex flex-col justify-center items-center m-auto mt-6">

        <div class="text-center">
            <p class="text-xl text-gray-900">Add Movie</p>
        </div>
        {{-- Edit Form --}}
        {!! Form::open(['action' => 'App\Http\Controllers\AdminMovieController@store', 'method' => 'POST', 'class' => 'flex flex-col p-2 m-2']) !!}

        {{ Form::label('movie-name', 'Movie name', ['class' => 'mb-2']) }}
        {{ Form::text('enName', null, ['class' => 'p-2 border border-primary rounded mb-2 outline-none bg-indigo-50']) }}

        {{ Form::label('movie-name-geo', 'Movie name geo', ['class' => 'mb-2']) }}
        {{ Form::text('kaName', null, ['class' => 'p-2 border border-primary rounded mb-2 outline-none bg-indigo-50']) }}

        {{ Form::submit('Add Movie', ['class' => 'text-center text-white mt-3 bg-gray-700 rounded px-4 py-2 hover:bg-gray-600 transition cursor-pointer']) }}

        {!! Form::close() !!}
    </div>
@endsection
