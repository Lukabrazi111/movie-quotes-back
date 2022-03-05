@extends('layouts.layout')

@section('content')
    <div class="container w-full max-w-lg m-auto">
        <section class="mt-36 text-center">
            <div class="mb-6">
                <img class="rounded-xl" src="{{ asset('img') . '/' . $quotes->thumbnail }}" alt="image">
            </div>

            <div class="mb-10">
                <p class="text-white text-3xl">"{{ $quotes->movie->name }}"</p>
            </div>

            <div class="mb-8">
                <p class="text-white text-2xl">
                    <a href="{{ route('post.show', $quotes->movie->id) }}"
                        class="hover:underline">{{ $quotes->quote }}</a>
                </p>
            </div>
        </section>
    </div>
@endsection
