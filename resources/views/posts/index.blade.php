@extends('layouts.layout')

@section('content')
    <div class="container w-full max-w-lg m-auto">
        <section class="mt-24 text-center">
            <div class="mb-6">
                <img src="{{ asset('img/image.png') }}" alt="image">
            </div>

            <div class="mb-10">
                <p class="text-white text-3xl">"{{ $movies->slug }}"</p>
            </div>

            <div class="mb-8">
                <p class="text-white text-2xl">
                    <a href="/posts/{{ $movies->id }}" class="hover:underline">{{ $movies->name }}</a>
                </p>
            </div>
        </section>
    </div>
@endsection
