<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Exceptions\Repository\NotFoundException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

interface CommonRepositoryInterface
{
    public const DEFAULT_LIST_LIMIT = 50;
    public const LIST_LIMIT_TEN = 10;

    /**
     * @param array $modelData
     *
     * @return Model
     */
    public function createFromArray(array $modelData): Model;

    /**
     * @param int $id
     * @param array $modelData
     * @return Model
     *
     * @throws NotFoundException
     */
    public function updateFromArray(int $id, array $modelData): Model;

    /**
     * @param array $whereClause
     * @param array $modelData
     *
     * @return bool
     */
    public function updateOrInsert(array $whereClause, array $modelData): bool;

    /**
     * @param array $whereClause
     * @param array $modelData
     *
     * @return bool
     */
    public function updateWithWhere(array $whereClause, array $modelData): bool;

    /**
     * @param int $id
     *
     * @return Model|null
     */
    public function find(int $id): ?Model;

    /**
     * @return Collection
     */
    public function all(): Collection;

    /**
     * @param int $id
     *
     * @throws ModelNotFoundException
     *
     * @return Model
     */
    public function findOrFail(int $id): Model;

    /**
     * @param array $conditionsArray
     * @param array $filterFields
     *
     * @return Collection
     */
    public function findBy(array $conditionsArray, array $filterFields = ['*']): Collection;

    /**
     * @param array $conditionsArray
     *
     * @return Model|null
     */
    public function findOneBy(array $conditionsArray): ?Model;

    /**
     * @param array $conditionsArray
     * @param array $relationsArray
     * @param array $filterFields
     *
     * @return Collection
     */
    public function findByAndWith(array $conditionsArray, array $relationsArray, array $filterFields = ['*']): Collection;

    /**
     * @param array $values
     *
     * @return bool
     */
    public function insertBulk(array $values): bool;

    /**
     * @param array $ids
     *
     * @return Collection
     */
    public function findIn(array $ids): Collection;
}
