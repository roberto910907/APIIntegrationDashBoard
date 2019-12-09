<?php

declare(strict_type=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\AdwordsDataServiceInterface;
use Illuminate\Support\Collection;

class AdwordsDataController extends Controller
{
    /**
     * @var AdwordsDataServiceInterface
     */
    private $adwordsDataService;

    /**
     * @param AdwordsDataServiceInterface $adwordsDataService
     */
    public function __construct(AdwordsDataServiceInterface $adwordsDataService)
    {
        $this->adwordsDataService = $adwordsDataService;
    }

    /**
     * @param string $clientAdwordsId
     *
     * @return Collection
     */
    public function listAdwordsData(string $clientAdwordsId): Collection
    {
        return $this->adwordsDataService->getAdwordsData((int) $clientAdwordsId);
    }
}
