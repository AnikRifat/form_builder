<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FormResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "title"=>$this->title,
            "method"=>$this->method,
            "action"=>$this->action,
            "is_active"=>$this->is_active,
            'fields'=>FormFieldResource::collection($this->whenLoaded('fields')),
        ];
    }
}
