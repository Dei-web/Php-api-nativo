<?php

class CodeGenerator
{
    public static function numericCode(int $length = 6): int
    {
        $min = (int) str_pad('1', $length, '0');
        $max = (int) str_pad('', $length, '9');
        return random_int($min, $max);
    }

    public static function alphaNumericCode(int $length = 8): string
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $code = '';
        for ($i = 0; $i < $length; $i++) {
            $code .= $characters[random_int(0, strlen($characters) - 1)];
        }
        return $code;
    }

    public static function hexCode(int $length = 16): string
    {
        return bin2hex(random_bytes($length / 2)); // siempre longitud par
    }
}
