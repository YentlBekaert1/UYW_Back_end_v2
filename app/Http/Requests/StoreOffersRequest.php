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
            'approach' => ['integer', 'required'],
            'url' => [],
            'contact' => [],
            'job' => ['string'],
            'status' => ['string'],
            'lat' => '',
            'lon' => '',
        ];
    }

    public function messages()
    {
        return [
            'approach.required' => "Please select a value for approach.",
            'category.required' => "Please select a value for category.",
            'title.required' => "Please enter a value for title.",
            'description.required' => "Please enter a value for description.",
        ];
    }
}
