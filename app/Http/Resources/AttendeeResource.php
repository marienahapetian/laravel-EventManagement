<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);

        return [
            'id' => $this->id,
            'name' => $this->user->name,
            'email' => $this->user->email,
            'user_id' => $this->event->user_id,
            'event_id' => $this->event->id
        ];
    }
}
