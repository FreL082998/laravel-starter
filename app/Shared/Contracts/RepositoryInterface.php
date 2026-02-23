<?php

declare(strict_types=1);

namespace Shared\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;

/**
 * @template TModel of Model
 */
interface RepositoryInterface
{
    /**
     * Get all records
     *
     * @return Collection<int, TModel>
     */
    public function all(array $columns = ['*']): Collection;

    /**
     * Find a record by ID
     */
    public function find(string $id, array $columns = ['*']): ?Model;

    /**
     * Find or fail a record by ID
     */
    public function findOrFail(string $id, array $columns = ['*']): Model;

    /**
     * Paginate records
     */
    public function paginate(int $perPage = 15, array $columns = ['*'], string $pageName = 'page'): Paginator;

    /**
     * Create a new record
     */
    public function create(array $data): Model;

    /**
     * Update a record
     */
    public function update(string $id, array $data): Model;

    /**
     * Delete a record
     */
    public function delete(string $id): bool;

    /**
     * Force delete a record
     */
    public function forceDelete(string $id): bool;

    /**
     * Restore a soft-deleted record
     */
    public function restore(string $id): bool;

    /**
     * Get the model instance
     */
    public function getModel(): Model;
}
