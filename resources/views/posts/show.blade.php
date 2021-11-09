@extends('layouts.layout')

@section('content')
    <div class="container w-full max-w-lg m-auto">
        <div class="mt-9">
            <a href="/" class="text-white py-2 px-4 bg-gray-500 rounded hover:bg-gray-700 transition delay-75">Go
                Back</a>
        </div>
        <section class="mt-24 text-center">

            <div class="mb-12">
                <p class="text-white text-3xl text-left">
                    {{ $post->title }}
                </p>
            </div>

            <div class="mb-6">
                <img src="{{ asset('img/image.png') }}" alt="image">

                <div class="mb-10 bg-white rounded p-4 text-left">
                    <p class="text-black text-2xl text-primary">"{{ $post->body }}"</p>
                </div>
            </div>

        </section>
    </div>
@endsection
