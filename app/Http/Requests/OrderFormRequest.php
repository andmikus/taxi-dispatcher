<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderFormRequest extends FormRequest
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
            'start_address' => 'required|string|max:255',
            'end_address' => 'required|string|max:255',
            'start_time' => 'date_format:"h:i"',
//            'driver_id' => 'required|integer'
        ];
    }
}
