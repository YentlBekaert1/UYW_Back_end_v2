<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOffersRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'string|required',
            'description' => ['required'],
            'category' => ['integer', 'required'],
            'tags' => [],
            'newtags' => [],
            'materials' => [],
            'submaterials' => [],
            'category' => ['integer'],
            'approach' => ['integer'],
            'url' => ['string'],
            'contact' => ['string'],
            'job' => ['string'],
            'status' => ['string'],
            'lat' => '',
            'lat' => '',
        ];
    }

    public function messages()
    {
        return [
            'description.required' => "Please enter a value for description.",
            'title.string' => 'HEYYYY use a string',
        ];
    }
}
