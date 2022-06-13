<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
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
            'name'    => 'required|string|max:255',
            'phone'   => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'body'    => 'required|string',
            'post_id' => 'nullable|numeric|exists:posts,id',
        ];
    }

    // Add ip and user agent to the validated data
    public function validated($key = null, $default = null)
    {
        return array_merge(parent::validated($key, $default), [
            'ip'         => $this->ip(),
            'user_agent' => $this->userAgent(),
        ]);
    }
}
