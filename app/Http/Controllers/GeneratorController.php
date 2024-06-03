<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\UuidFactory;
use Ramsey\Uuid\Generator\RandomBytesGenerator;

class GeneratorController extends Controller
{

    public function index() {
        return view('/password-generator');
    }

    public function generatePassword(Request $request) {

        $length = $request->input('length', 12);
        $useSmall = $request->has('small');
        $useCap = $request->has('capital');
        $useNumbers = $request->has('numbers');
        $useSymbols = $request->has('symbols');

        $pools = [];

        // Check if each pool is requested, if so, add it to the pools array
        if ($useSmall) {
            $pools[] = 'abcdefghijklmnopqrstuvwxyz';
        }
        if ($useCap) {
            $pools[] = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        }
        if ($useNumbers) {
            $pools[] = '0123456789';
        }
        if ($useSymbols) {
            $pools[] = '!#$%&()*+@^';
        }

        // Flash input data to the session
        $request->flash();

        // Perform error checking
        if (empty($pools)) {
            return redirect('/password-generator')->withErrors(['At least one character type must be selected'])->withInput();
        }

        $password = '';
        $generator = new RandomBytesGenerator(new UuidFactory());

        // Generate the password
        for ($i = 0; $i < $length; $i++) {
            // Randomly select a pool
            $pool = $pools[array_rand($pools)];
            // Randomly select a character from the pool
            $charIndex = ord($generator->generate(1)) % strlen($pool);
            $password .= $pool[$charIndex];
        }
    
        return view('/password-generator', ['generatedPassword' => $password]);
    }
}
