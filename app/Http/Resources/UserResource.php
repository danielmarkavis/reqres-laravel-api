<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{

    /**
     * Serialize the Json
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->resource->id,
            'email'      => $this->resource->email,
            'first_name' => $this->resource->first_name,
            'last_name'  => $this->resource->last_name,
            'avatar'     => $this->resource->avatar,
        ];
    }
}
