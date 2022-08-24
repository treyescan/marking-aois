<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StartSessionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'naam' => 'required|string',
            'leeftijd' => 'required|int',
            'rijjaren' => 'required|int',
            'cbr' => 'required|in:ja,nee',
            'stad' => 'required|in:ja,nee',
            'noclaim' => 'required|int',
        ];
    }
}
