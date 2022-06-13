<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
            'title'            => 'required|string|max:255',
            'slug'             => 'required|string|unique:posts|max:255',
            'excerpt'          => 'required|string',
            'body'             => 'required|string',
            'cover'            => 'required|string|max:255',
            'status'           => 'required|string|in:draft,private,public',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords'    => 'nullable|string',
            'published_at'     => 'nullable|date',
        ];
    }
}
