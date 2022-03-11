@extends('layouts.admin-layout')
<div class="mt-9 text-center">
    <a href="{{ route('admin.quotes') }}"
       class="text-white py-2 px-4 bg-gray-500 rounded hover:bg-gray-700 transition delay-75">Go
        Back</a>
</div>

@section('content')
    <div class="bg-gray-400 rounded p-10 w-1/2 flex flex-col justify-center items-center m-auto mt-6">

        <div class="text-center">
            <p class="text-xl text-gray-900">Edit Quotes</p>
        </div>

        {{-- Edit Form --}}
        <form action="{{ route('admin.update-quotes', $quotes->id) }}" enctype="multipart/form-data" method="POST" class="flex flex-col p-2 m-2">
            @csrf
            @method('PUT')

            <label for="enQuote" class="mb-2">Quote</label>
            <input type="text" value="{{ $quotes->getTranslation('quote', 'en') }}" name="enQuote" id="enQuote"
                   class="p-2 border border-primary rounded mb-2 outline-none bg-indigo-50">
            <label for="enQuote" class="mb-2">Quote Geo</label>
            <input type="text" value="{{ $quotes->getTranslation('quote', 'ka') }}" name="kaQuote" id="kaQuote"
                   class="p-2 border border-primary rounded mb-2 outline-none bg-indigo-50">

            <input type="file" name="quoteImg" id="quoteImg">
            <p class="text-center">Movies</p>
            <select name="movieId" id="cards" class="py-2 rounded">
                @foreach($movies as $movie)
                    <option value="{{ $movie->id }}">{{ $movie->name }}</option>
                @endforeach
            </select>
            <button type="submit"
                    class="text-center text-white mt-3 bg-gray-700 rounded px-4 py-2 hover:bg-gray-600 transition cursor-pointer">
                Edit
            </button>
        </form>
    </div>

@endsection
