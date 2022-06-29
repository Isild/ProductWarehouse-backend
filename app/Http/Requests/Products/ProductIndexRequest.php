<?php

namespace App\Http\Requests\Products;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductIndexRequest extends FormRequest
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
            'limit'     => 'integer|min:1|max:50',
            'sort_by'   => 'string|in:name,created_at,updated_at',
            'search'    => 'string|min:2|max:255',
            'order_by'  => 'string|in:asc,desc',
        ];
    }
}
