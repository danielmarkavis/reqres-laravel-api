<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaginateResource extends JsonResource
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
        $links = [ // I would create a whole class for Repository Pagination.
            'next_page' => $this->resource->page < $this->resource->total_pages ? $this->resource->page + 1 : null,
            'prev_page' => $this->resource->page > 1 ? $this->resource->page - 1 : null,
        ];

        return [
            'page'        => $this->resource->page,
            'per_page'    => $this->resource->per_page,
            'total'       => $this->resource->total,
            'total_pages' => $this->resource->total_pages,
            'data'        => UserResource::collection($this->resource->data),
            'links'       => $links,
        ];
    }

}
