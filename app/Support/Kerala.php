<?php

namespace App\Support;

final class Kerala
{
    /**
     * @var list<string>
     */
    public const DISTRICTS = [
        'Alappuzha',
        'Ernakulam',
        'Idukki',
        'Kannur',
        'Kasaragod',
        'Kollam',
        'Kottayam',
        'Kozhikode',
        'Malappuram',
        'Palakkad',
        'Pathanamthitta',
        'Thiruvananthapuram',
        'Thrissur',
        'Wayanad',
    ];

    public static function digitsOnly(string $value): string
    {
        return preg_replace('/\D+/', '', $value) ?? '';
    }

    public static function isValidPhone(string $value): bool
    {
        $digits = self::digitsOnly($value);

        if (str_starts_with($digits, '91') && strlen($digits) === 12) {
            $digits = substr($digits, 2);
        }

        if (str_starts_with($digits, '0') && strlen($digits) === 11) {
            $digits = substr($digits, 1);
        }

        if (preg_match('/^[6-9]\d{9}$/', $digits)) {
            return true;
        }

        return (bool) preg_match('/^(47\d|48\d|49\d)\d{7}$/', $digits);
    }

    public static function isValidPincode(string $value): bool
    {
        return (bool) preg_match('/^(67|68|69)\d{4}$/', self::digitsOnly($value));
    }
}
