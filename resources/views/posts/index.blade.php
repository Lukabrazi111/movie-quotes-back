@extends('layouts.layout')

@section('content')
    <div class="container w-full max-w-lg m-auto">
        <section class="mt-24 text-center">
            @foreach($movies as $movie)
                <div class="mb-6">
                    <img src="{{ asset('img/image.png') }}" alt="image">
                </div>

                <div class="mb-10">
                    <p class="text-white text-3xl">"{{ $movie->slug }}"</p>
                </div>

                <div class="mb-8">
                    <p class="text-white text-2xl">
                        <a href="/posts/{{ $movie->id }}" class="hover:underline">{{ $movie->name }}</a>
                    </p>
                </div>
            @endforeach
        </section>
    </div>
@endsection
