@extends('layouts.app')

@section('content')

<div class="flex justify-center items-center min-h-screen w-full bg-black">
    <div class="text-center">
        <div class="flex flex-col w-1200 h-720 font-bold text-neon-green">
            <h1 class="text-5xl mb-5">HOME</h1>
            <div class="flex">
                <a href="{{ route('password.generator') }}" class="bg-transparent border border-solid border-neon-green hover:bg-neon-green hover:text-black px-5 py-3 rounded mr-3 mb-1">Password Generator</a>
                <a href="{{ route('pizza.home') }}" class="bg-transparent border border-solid border-neon-green hover:bg-neon-green hover:text-black px-6 py-3 rounded mr-1 mb-1">Pizza Parlour</a>
            </div>
        </div>
    </div>
</div>



@endsection