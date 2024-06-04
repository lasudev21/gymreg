<?php

namespace App\Services;

class StringUtil
{
    public static function capitalizarPrimerasLetras($texto)
    {
        $palabras = explode(' ', $texto);

        foreach ($palabras as &$palabra) {
            $palabra = ucfirst(strtolower($palabra));
        }

        return implode(' ', $palabras);
    }
}
