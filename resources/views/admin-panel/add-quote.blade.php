@extends('layouts.admin-layout')
<div class="mt-9 text-center">
    <a href="{{ route('admin.quotes') }}"
       class="text-white py-2 px-4 bg-gray-500 rounded hover:bg-gray-700 transition delay-75">Go
        Back</a>
</div>

@section('content')
    <div class="bg-gray-400 rounded p-10 w-1/2 flex flex-col justify-center items-center m-auto mt-6">

        <div class="text-center">
            <p class="text-xl text-gray-900">Add Quotes</p>
        </div>

        {{-- Edit Form --}}
        <form action="{{ route('admin.store-quotes') }}" enctype="multipart/form-data" method="POST"
              class="flex flex-col p-2 m-2">
            @csrf

            <label for="enQuote" class="mb-2">Quote name</label>
            <input type="text" id="enQuote" name="enQuote"
                   class="p-2 border border-primary rounded mb-2 outline-none bg-indigo-50">

            <label for="kaQuote" class="mb-2">Quote name geo</label>
            <input type="text" id="kaQuote" name="kaQuote"
                   class="p-2 border border-primary rounded mb-2 outline-none bg-indigo-50">

            <input type="file" name="quoteImg" id="quoteImg">
            <p class="text-center">Movies</p>
            <select name="movieId" id="movieId" class="py-2 rounded">
                @foreach ($movies as $movie)
                    <option value="{{ $movie->id }}">{{ $movie->name }}</option>
                @endforeach
            </select>
            <button type="submit"
                    class="text-center text-white mt-3 bg-gray-700 rounded px-4 py-2 hover:bg-gray-600 transition cursor-pointer">
                Add
                Quote
            </button>
        </form>
    </div>
@endsection
