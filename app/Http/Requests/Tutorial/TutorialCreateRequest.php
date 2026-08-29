<?php

namespace App\Http\Requests\Tutorial;

use App\Http\Requests\MyCustomRequest;

class TutorialCreateRequest extends MyCustomRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'tutorials'                 => 'nullable|array',
            'tutorials.*.title'        => 'required_with:tutorials|string|max:255',
            'tutorials.*.slug'         => 'nullable|string|max:255',
            'tutorials.*.description'  => 'nullable|string',
            'tutorials.*.content'      => 'nullable|string',
            'tutorials.*.video_url'    => 'nullable|string|max:500',
            'tutorials.*.image'        => 'nullable|string|max:500',
            'tutorials.*.document'     => 'nullable|string|max:500',
            'tutorials.*.category'     => 'nullable|string|max:100',
            'tutorials.*.target_role'  => 'nullable|string|max:100',
            'tutorials.*.order'        => 'nullable|integer',
            'tutorials.*.is_published' => 'nullable|boolean',

            // Allow direct creation of a single tutorial
            'title'        => 'required_without:tutorials|string|max:255',
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
