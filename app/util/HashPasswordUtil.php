<?php

namespace App\util;

use Illuminate\Support\Facades\Hash;

class HashPasswordUtil
{

    public static function hashPassword($plaintext){
        $make = Hash::make($plaintext);

        return $make;
    }

    public static function checkPassword($password,$hashedPassword){
        return Hash::check($password, $hashedPassword);
    }

}
