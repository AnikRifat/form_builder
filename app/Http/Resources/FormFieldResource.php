<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FormFieldResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
          "form_id"=>$this->form_id,
          "type"=>$this->type,
          "name"=>$this->name,
          "label"=>$this->label,
          "placeholder"=>$this->placeholder,
          "is_required"=>$this->is_required,
          "options"=>$this->options,
          "order"=>$this->order,
        ];
    }
}
