<?php

declare(strict_type=1);

namespace App\Services;

use App\Models\Adwords\Config\Config;
use App\Models\Adwords\Reports\AdwordsDataReport;
use App\Models\Adwords\Session\Session;
use App\Repositories\AdwordsDataRepository;
use App\Services\Interfaces\AdwordsDataServiceInterface;
use Illuminate\Support\Collection;

class AdwordsDataService implements AdwordsDataServiceInterface
{
    /**
     * @var AdwordsDataReport
     */
    private $adwordsDataReport;

    /**
     * @var AdwordsDataRepository
     */
    private $adwordsDataRepository;

    /**
     * @param AdwordsDataReport $adwordsDataReport
     * @param AdwordsDataRepository $adwordsDataRepository
     */
    public function __construct(
        AdwordsDataReport $adwordsDataReport,
        AdwordsDataRepository $adwordsDataRepository
    ) {
        $this->adwordsDataReport = $adwordsDataReport;
        $this->adwordsDataRepository = $adwordsDataRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function syncAdwordsData(int $clientAdwordsId): int
    {
        $config = (new Config())
            ->setSession(Session::create($clientAdwordsId))
            ->setClientId($clientAdwordsId);

        $adwordsData = $this->adwordsDataReport->setConfig($config)->run();

        $this->adwordsDataRepository->insertBulk($adwordsData->toArray());

        return $adwordsData->count();
    }

    /**
     * {@inheritdoc}
     */
    public function getAdwordsData(int $clientAdwordsId): Collection
    {
        return $this->adwordsDataRepository->findBy(['client_adwords_id' => $clientAdwordsId]);
    }
}
