<?php


namespace App\Http\Requests;


class IndexAnnouncementRequest extends ApiRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'sort_field' => ['sometimes', 'in:price,created_at'],
            'title' => ['sometimes', 'in:desc,asc'],
        ];
    }

}
