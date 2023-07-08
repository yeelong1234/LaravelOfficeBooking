<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RoomResource extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request) {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "location" => $this->location,
            "description" => $this->description,
            "photo" => $this->photo,
            "price" => $this->price,
            "capacity" => $this->capacity,
        ];
    }
}