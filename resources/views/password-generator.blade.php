@extends('layouts.app')

@section('content')
    <div class="flex justify-center items-center min-h-screen w-full bg-black">
        <div class="text-center">
            <div class="flex flex-col w-1200 h-720">
                <a href="/" class="text-l absolute top-10 left-10 text-neon-green font-bold mr-1 mb-1 transition duration-300 ease-in-out hover:text-l" title="Go home">↰ Back</a>
                <h1 class="text-5xl text-neon-green font-bold mb-5">Password Generator</h1>
                <form action="{{ route('generate.password') }}" method="POST">
                    @csrf
                    <div class="border border-solid text-neon-green border-neon-green px-4 py-5 flex flex-col md:flex-row md:space-x-4 w-1200 h-720 mb-5">
                        <div class="length flex-1">
                            <label for="length">Password Length:</label>
                            <div class="self-center items-center justify-center">
                                <input class="slider mr-2" type="range" id="length" name="length" min="8" max="30" value="{{ old('length', 12) }}" onchange="updateTextInput(this.value);">
                                <p id="lengthOutput">{{ old('length', 12) }}</p>
                            </div>
                        </div>
                        <div class="check flex-1">
                            <div class="flex flex-col space-y-2">
                                <div class="flex self-center items-center">
                                    <input type="checkbox" id="small" name="small" class="rounded border-gray-300 text-neon-green shadow-sm focus:ring-neon-green focus:border-neon-green" {{ old('small') ? 'checked' : '' }}>
                                    <label for="small" class="ml-2 text-neon-green">Include Small Letters</label>
                                </div>
                                <div class="flex self-center items-center">
                                    <input type="checkbox" id="capital" name="capital" class="rounded border-gray-300 text-neon-green shadow-sm focus:ring-neon-green focus:border-neon-green" {{ old('capital') ? 'checked' : '' }}>
                                    <label for="capital" class="ml-2 text-neon-green">Include Capital Letters</label>
                                </div>
                                <div class="flex self-center items-center">
                                    <input type="checkbox" id="numbers" name="numbers" class="rounded border-gray-300 text-neon-green shadow-sm focus:ring-neon-green focus:border-neon-green" {{ old('numbers') ? 'checked' : '' }}>
                                    <label for="numbers" class="ml-2 text-neon-green">Include Numbers</label>
                                </div>
                                <div class="flex self-center items-center">
                                    <input type="checkbox" id="symbols" name="symbols" class="rounded border-gray-300 text-neon-green shadow-sm focus:ring-neon-green focus:border-neon-green" {{ old('symbols') ? 'checked' : '' }}>
                                    <label for="symbols" class="ml-2 text-neon-green">Include Symbols</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="border border-neon-green text-neon-green hover:text-black hover:bg-neon-green font-bold px-4 py-2 rounded mt-4">Generate Password</button>
                </form>
            </div>
            <div class="mt-8 results">
                @if($errors->any())
                    <div class="bg-red-500 text-white p-4 rounded mb-4">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(isset($generatedPassword) && $generatedPassword)
                    <p class="text-2xl text-neon-green">Generated Password:</p>
                    <div class="flex items-center justify-center">
                        <p id="generatedPassword" class="text-3xl text-neon-green font-bold">{{ $generatedPassword }}</p>
                        <button onclick="copyPassword()" class="text-neon-green ml-2" title="Click me to Copy"><i class="fa-solid fa-copy fa-xl pl-5"></i></button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        function updateTextInput(val) {
            document.getElementById('lengthOutput').innerHTML = val;
        }

        function copyPassword() {
            var passwd = document.getElementById('generatedPassword').innerText;

            var tempInput = document.createElement('input');
            tempInput.value = passwd;
            document.body.appendChild(tempInput);

            tempInput.select();
            tempInput.setSelectionRange(0, 99999);

            document.execCommand('copy');
            document.body.removeChild(tempInput);

            alert('Password copied to clipboard');
        }
    </script>

@endsection
