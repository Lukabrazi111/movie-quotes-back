@extends('layouts.admin-layout')
{{--<a href="{{ route('index') }}" class="text-white py-2 px-4 bg-gray-500 rounded hover:bg-gray-700 transition delay-75">Go--}}
{{--    Back</a>--}}
<div class="mt-9 flex justify-between px-20">
    <div>
        <a href="{{ route('admin.show') }}" class="ml-2 hover:underline">Movies</a>
        <a href="{{ route('admin.quotes') }}" class="ml-2 hover:underline">Quotes</a>
    </div>
    <div>
        <a href="{{ route('admin.add-movie') }}" class="ml-2 hover:underline">Add movie</a>
        <a href="{{ route('admin.add-quotes') }}" class="ml-2 hover:underline">Add quote</a>
    </div>
</div>

{{-- Check session with success message --}}
@if(session('success'))
    <div class="py-4 px-6 w-full max-w-2xl text-center m-auto mt-4 bg-green-300 text-black rounded bg-opacity-60">
        <p class="text-xl text-">{{ session('success') }}</p>
    </div>
@endif

@section('content')
    {{-- Admin Panel --}}
    <div class="text-center">
        <h1 class="text-2xl">Movies</h1>
    </div>
    <div class="flex justify-center w-auto items-center flex-col mt-10">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                @foreach($movies as $movie)
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg mb-3">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Name
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Name Geo
                                </th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">Edit</span>
                                </th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">Delete</span>
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $movie->getTranslation('name', 'en') }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $movie->getTranslation('name', 'ka') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('admin.edit', $movie->id) }}"
                                       class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('admin.destroy', $movie->id) }}"
                                       class="text-red-500 hover:text-red-700">Delete</a>
                                </td>
                            </tr>
                            {{-- More People --}}
                            </tbody>
                        </table>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
