<?php

namespace App\Http\Requests\API;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class NewsSearchRequest extends FormRequest
{
    
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'query'     =>  'required|string|min:3',
            'category'  =>  'sometimes|string|in:business,entertainment,health,politics,sports,technology',
            'source'    =>  'sometimes|string|exists:news,source',
            'author'    =>  'sometimes|string|exists:news,author',
            'from_date' =>  'sometimes|date',
            'to_date'   =>  'sometimes|date',
        ];
    }


    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors()));
    }

    public function messages()
    {
        return [
            'query.required'    =>  __("api.required", ["PARAM" => 'query']),
            'query.string'      =>  __("api.string_type_error", ["PARAM" => 'query']),
            'query.min'         =>  __("api.min_length_error", ["PARAM" => 'query']),
            'category.string'   =>  __("api.string_type_error", ["PARAM" => 'category']),
            'category.in'       =>  __("api.out_of_list_category",  ["PARAM" => "category"]),
            'source.string'     =>  __("api.string_type_error", ["PARAM" => 'source']),
            'source.exists'     =>  __("api.missing_data_in_db", ["PARAM"   =>  "source"]),
            'author.string'     =>  __("api.string_type_error", ["PARAM" => 'author']),
            'author.exists'     =>  __("api.missing_data_in_db", ["PARAM"   =>  "author"]),
            'from_date.date'    =>  __("api.date_format_error", ["PARAM"    =>  "from_date"]),
            'to_date.date'      =>  __("api.date_format_error", ["PARAM"    =>  "to_date"]),
        ];
    }
}
