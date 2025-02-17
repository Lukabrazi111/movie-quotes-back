@extends('layouts.admin-layout')
<div class="mt-9 text-center">
    <a href="{{ route('admin.show') }}"
       class="text-white py-2 px-4 bg-gray-500 rounded hover:bg-gray-700 transition delay-75">Go
        Back</a>
</div>

@section('content')
    <div class="bg-gray-400 rounded p-10 w-1/2 flex flex-col justify-center items-center m-auto mt-6">

        <div class="text-center">
            <p class="text-xl text-gray-900">Edit Movie</p>
        </div>

        {{-- Edit Form --}}
        <form action="{{ route('admin.update', $movies->id) }}" method="POST" class="flex flex-col p-2 m-2">
            @csrf
            @method('PUT')

            <label for="enMovie" class="mb-2">Name</label>
            <input type="text" id="enMovie" name="enMovie" value="{{ $movies->getTranslation('name', 'en') }}"
                   class="p-2 border border-primary rounded mb-2 outline-none bg-indigo-50">
            <label for="kaMovie" class="mb-2">Name Geo</label>
            <input type="text" id="kaMovie" name="kaMovie" value="{{ $movies->getTranslation('name', 'ka') }}"
                   class="p-2 border border-primary rounded mb-2 outline-none bg-indigo-50">

            <button type="submit"
                    class="text-center text-white mt-3 bg-gray-700 rounded px-4 py-2 hover:bg-gray-600 transition cursor-pointer">
                Edit
            </button>
        </form>
    </div>

@endsection
