@extends('layouts.layout')

@section('content')
    <div class="container w-full max-w-lg m-auto">
        <section class="mt-24 text-center">

            <div class="mb-6">
                <img src="{{ asset('img/image.png') }}" alt="image">
            </div>

            <div class="mb-10">
                <p class="text-white text-3xl">"What should I tell you your mother?"</p>
            </div>

            <div>
                <p class="text-white text-2xl">
                    <a href="#" class="hover:underline">The Son Of Soldier</a>
                </p>
            </div>
        </section>
    </div>
@endsection
