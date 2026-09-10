<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCitizenRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nik' => ['required', 'string', 'max:16', 'unique:citizens,nik'],
            'name' => ['required', 'string', 'max:255'],
            'wife_name' => ['nullable', 'string', 'max:255'],
            'house_number' => ['required', 'string', 'max:50'],
            'marital_status' => ['required', 'in:single,married,divorced,widowed'],
            'children_count' => ['required', 'integer', 'min:0'],
            'income_range' => ['required', 'in:0_3jt,4_8jt,9_15jt,above_15jt'],
            'status' => ['required', 'in:active,moved,deceased,inactive'],
        ];
    }
}
