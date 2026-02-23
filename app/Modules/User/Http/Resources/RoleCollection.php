<?php

declare(strict_types=1);

namespace Modules\User\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * RoleCollection is a resource collection for the Role model.
 *
 * It transforms a collection of Role models into an array format suitable for API responses,
 * including pagination metadata.
 *
 * @category Resources
 */
class RoleCollection extends ResourceCollection
{
    // Specify the resource that this collection collects
    public $collects = RoleResource::class;

    /**
     * Transform the resource collection into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection,
            'pagination' => [
                'total' => $this->total ?? 0,
                'per_page' => $this->perPage ?? 15,
                'current_page' => $this->currentPage ?? 1,
                'last_page' => $this->lastPage ?? 1,
            ],
        ];
    }
}
