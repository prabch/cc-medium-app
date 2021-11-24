<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Services\MediumService;

class Tokencheck implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $medium = new MediumService($value);
        $profile = $medium->get_profile();
        return ($profile['status'] == 200);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Invalid medium integration token';
    }
}
