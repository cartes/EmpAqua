<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class BlacklistWords implements Rule
{
    protected $blacklist = [];

    public function __construct()
    {
        $path = storage_path('app/blacklist_words.txt');

//dd(file_exists($path), storage_path('app/blacklist_words.txt'));
        if (file_exists($path)) {
            $this->blacklist = array_map('trim', file($path));
        }
    }

    public function passes($attribute, $value)
    {
        $valueLower = mb_strtolower($value, 'UTF-8');

        foreach ($this->blacklist as $word) {
            if (mb_stripos($valueLower, $word) !== false) {
                return false;
            }
        }

        return true;
    }

    public function message()
    {
        return 'El campo contiene palabras no permitidas.';
    }
}
