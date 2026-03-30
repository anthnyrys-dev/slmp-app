<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'phone' => $this->phone,
            'website' => $this->website,
            'address' => $this->address ? [
                'street' => $this->address->street,
                'city' => $this->address->city,
                'zipcode' => $this->address->zipcode,
                'lat' => $this->address->lat,
                'lng' => $this->address->lng,
            ] : [],
            'company' => $this->company ? [
                'name' => $this->company->name,
                'catch_phrase' => $this->company->catch_phrase,
                'bs' => $this->company->bs,
            ] : [],
        ];
    }
}
