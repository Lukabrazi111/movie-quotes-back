@extends('layouts.admin-layout')
<div class="mt-9 text-center">
    <a href="/admin/panel" class="text-white py-2 px-4 bg-gray-500 rounded hover:bg-gray-700 transition delay-75">Go
        Back</a>
</div>

@section('content')
    <div class="bg-gray-400 rounded p-10 w-1/2 flex flex-col justify-center items-center m-auto mt-6">

        <div class="text-center">
            <p class="text-xl text-gray-900">Edit Quotes</p>
        </div>

        {{-- Edit Form --}}
        {!! Form::open(['action' => ['App\Http\Controllers\AdminController@update', $quotes->id], 'method' => 'POST', 'class' => 'flex flex-col p-2 m-2']) !!}

        {{ Form::label('text', 'Name', ['class' => 'mb-2']) }}
        {{ Form::text('name', $quotes->movie->name, ['class' => 'p-2 border border-primary rounded mb-2 outline-none bg-indigo-50']) }}

        {{ Form::label('textarea', 'Quote', ['class' => 'mb-2']) }}
        {{ Form::textarea('textarea', $quotes->quote, ['class' => 'border border-primary rounded p-2 outline-none bg-indigo-50', 'cols' => '40', 'rows' => '7']) }}

        {{ Form::submit('Edit', ['class' => 'text-center text-white mt-3 bg-gray-700 rounded px-4 py-2 hover:bg-gray-600 transition cursor-pointer']) }}

        {{ Form::hidden('_method', 'PUT') }}

        {!! Form::close() !!}
    </div>

@endsection
