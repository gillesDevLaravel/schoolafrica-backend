<?php

namespace App\Http\Requests\Tutorial;

use App\Http\Requests\MyCustomRequest;

class TutorialUpdateRequest extends MyCustomRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title'        => 'sometimes|required|string|max:255',
            'slug'         => 'nullable|string|max:255',
            'description'  => 'nullable|string',
            'content'      => 'nullable|string',
            'video_url'    => 'nullable|string|max:500',
            'image'        => 'nullable|string|max:500',
            'document'     => 'nullable|string|max:500',
            'category'     => 'nullable|string|max:100',
            'target_role'  => 'nullable|string|max:100',
            'order'        => 'nullable|integer',
            'is_published' => 'nullable|boolean',
        ];
    }
}
