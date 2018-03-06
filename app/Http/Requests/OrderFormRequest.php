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
            'origin_address' => 'required|string|max:255',
            'destination_address' => 'required|string|max:255',
            'origin_location' => 'required|json',
            'destination_location' => 'required|json',
            'start_time' => 'date_format:"H:i"',
//            'driver_id' => 'required|integer'
        ];
    }
}
