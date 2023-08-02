<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;


class PhoneNumberValidator implements Rule
{
    public function passes($attribute, $value)
    {
        return $this->validatePhoneNumber($value);
    }

    public function message()
    {
        return 'The provided phone number is not valid.';
    }

    private function validatePhoneNumber($value)
    {
        $value = preg_replace('/[^0-9]/', '', $value);
        return strlen($value) === 10;
    }
}

?>
