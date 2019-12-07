<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\AdwordsDataServiceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

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
     * @return JsonResponse
     */
    public function listAdwordsData(): JsonResponse
    {
        return $this->adwordsDataService->asd();
    }
}
