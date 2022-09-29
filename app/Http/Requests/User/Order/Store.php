<?php

namespace App\Http\Requests\User\Order;

use DateTime;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class Store extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $id = Auth::id();

        return [
            "name" => "required",
            "email" => "required|email|unique:users,email,$id",
            "occupation" => "required",
            "card_number" => "required|numeric|digits_between:8,16",
            "expired" => [
                "required",
                "date",
                "date_format:Y-m",
                "after_or_equal:now",
            ],

            "cvc" => "required|numeric|digits:3",
        ];
    }
}
