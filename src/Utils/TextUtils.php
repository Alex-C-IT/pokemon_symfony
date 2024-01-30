<?php

namespace App\Utils;

class TextUtils
{
    public static function bonjourOuBonsoir(): string
    {
        $heure = date('H');
        if ($heure >= 5 && $heure <= 17) {
            return 'Bonjour';
        } else {
            return 'Bonsoir';
        }
    }
}
