<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\Tokencheck;

class UpdateRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function attributes(): array
    {
        return [
            'token' => 'medium integration token',
        ];
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:50'],
            'token' => ['required', 'string', 'max:255', new Tokencheck],
        ];
    }
    
}
