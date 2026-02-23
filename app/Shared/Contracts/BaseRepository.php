<?php

declare(strict_types=1);

namespace Shared\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;

abstract class BaseRepository implements RepositoryInterface
{
    protected Model $model;

    abstract public function getModel(): Model;

    public function all(array $columns = ['*']): Collection
    {
        return $this->getModel()->all($columns);
    }

    public function find(string $id, array $columns = ['*']): ?Model
    {
        return $this->getModel()->find($id, $columns);
    }

    public function findOrFail(string $id, array $columns = ['*']): Model
    {
        return $this->getModel()->findOrFail($id, $columns);
    }

    public function paginate(int $perPage = 15, array $columns = ['*'], string $pageName = 'page'): Paginator
    {
        return $this->getModel()->paginate($perPage, $columns, $pageName);
    }

    public function create(array $data): Model
    {
        return $this->getModel()->create($data);
    }

    public function update(string $id, array $data): Model
    {
        $model = $this->findOrFail($id);
        $model->update($data);

        return $model;
    }

    public function delete(string $id): bool
    {
        $model = $this->findOrFail($id);

        return (bool) $model->delete();
    }

    public function forceDelete(string $id): bool
    {
        $model = $this->getModel()->withTrashed()->findOrFail($id);

        return (bool) $model->forceDelete();
    }

    public function restore(string $id): bool
    {
        $model = $this->getModel()->withTrashed()->findOrFail($id);

        return (bool) $model->restore();
    }
}
