<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class AnnouncementResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $image = $this->images->first();
        return [
            'title' => $this->title,
            'price' => $this->price,
            'photo' => $image->is_uploaded ? asset(Storage::url($image->path)) : '',
        ];
    }
}
