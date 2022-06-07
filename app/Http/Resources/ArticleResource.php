<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            '_user_id' => $request->user()->user_name,
            'articleImage' => ArticleImageResource::collection($this->whenLoaded('articleImages')),
        ];
    }
}
