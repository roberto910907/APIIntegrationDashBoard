<?php

declare(strict_types=1);

namespace App\Repositories\Traits;

use App\Exceptions\Repository\NotFoundException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

trait CommonRepository
{
    /**
     * @return Model
     */
    abstract protected function getModel(): Model;

    /**
     * @param array $modelData
     *
     * @return Model
     */
    public function createFromArray(array $modelData): Model
    {
        return $this->getModel()->create($modelData);
    }

    /**
     * @param int $id
     * @param array $modelData
     *
     * @return Model
     *
     * @throws NotFoundException
     */
    public function updateFromArray(int $id, array $modelData): Model
    {
        $model = $this->getModel()->find($id);
        if ($model === null) {
            throw new NotFoundException(sprintf(get_class($this->getModel()) . ' ID: [%s] not found', $id));
        }
        $model->update($modelData);

        return $model;
    }

    /**
     * {@inheritdoc}
     */
    public function updateOrInsert(array $whereClause, array $modelData): bool
    {
        return (bool) $this->getModel()->newQuery()->updateOrInsert($whereClause, $modelData);
    }

    /**
     * {@inheritdoc}
     */
    public function updateWithWhere(array $whereClause, array $modelData): bool
    {
        return (bool) $this->getModel()->newQuery()->where($whereClause)->update($modelData);
    }

    /**
     * @param int $id
     *
     * @return Model|null
     */
    public function find(int $id): ?Model
    {
        return $this->getModel()->find($id);
    }

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->getModel()->all();
    }

    /**
     * @param int $id
     *
     * @throws ModelNotFoundException
     *
     * @return Model
     */
    public function findOrFail(int $id): Model
    {
        return $this->getModel()->findOrFail($id);
    }

    /**
     * @param array $conditionsArray
     * @param array $filterFields
     *
     * @return Collection
     */
    public function findBy(array $conditionsArray, array $filterFields = ['*']): Collection
    {
        return $this->getModel()->where($conditionsArray)->get($filterFields);
    }

    /**
     * @param array $conditionsArray
     *
     * @return Model|null
     */
    public function findOneBy(array $conditionsArray): ?Model
    {
        return $this->getModel()->where($conditionsArray)->first();
    }

    /**
     * @param array $conditionsArray
     * @param array $relationsArray
     * @param array $filterFields
     *
     * @return Collection
     */
    public function findByAndWith(array $conditionsArray, array $relationsArray, array $filterFields = ['*']): Collection
    {
        return $this->getModel()->where($conditionsArray)->with($relationsArray)->get($filterFields);
    }

    /**
     * @param array $values
     *
     * @return bool
     */
    public function insertBulk(array $values): bool
    {
        return (bool) $this->getModel()->newQuery()->insert($values);
    }

    /**
     * @param array $ids
     *
     * @return Collection
     */
    public function findIn(array $ids): Collection
    {
        return $this->getModel()->whereIn('id', $ids)->get();
    }
}
