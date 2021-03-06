<?php

namespace App\Services\Interfaces;

use Illuminate\Support\Collection;

interface AdwordsDataServiceInterface
{
    /**
     * @param int $clientAdwordsId
     *
     * @return int
     */
    public function syncAdwordsData(int $clientAdwordsId): int;

    /**
     * @param int $clientAdwordsId
     *
     * @return Collection
     */
    public function getAdwordsData(int $clientAdwordsId): Collection;
}
