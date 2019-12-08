<?php

declare(strict_type=1);

namespace App\Http\Controllers;

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
     * @param int $clientAdwordsId
     *
     * @return Collection
     */
    public function listAdwordsData(int $clientAdwordsId): Collection
    {
        return $this->adwordsDataService->getAdwordsData($clientAdwordsId);
    }
}
