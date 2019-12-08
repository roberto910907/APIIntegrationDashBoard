<?php

declare(strict_type=1);

namespace App\Services;

use App\Models\Adwords\Config\Config;
use App\Models\Adwords\Reports\AdwordsDataReport;
use App\Models\Adwords\Session\Session;
use App\Services\Interfaces\AdwordsDataServiceInterface;
use Illuminate\Support\Collection;

class AdwordsDataService implements AdwordsDataServiceInterface
{
    /**
     * @var AdwordsDataReport
     */
    private $adwordsDataReport;

    public function __construct(AdwordsDataReport $adwordsDataReport)
    {
        $this->adwordsDataReport = $adwordsDataReport;
    }

    /**
     * {@inheritdoc}
     */
    public function getAdwordsData(int $clientAdwordsId): Collection
    {
        $config = (new Config())->setSession(Session::create($clientAdwordsId));
        $reportData = $this->adwordsDataReport->setConfig($config)->run();

        return $this->processReportResult($reportData);
    }

    /**
     * @param string $reportData
     *
     * @return Collection
     */
    public function processReportResult(string $reportData): Collection
    {
        $dataArray = [];
        $lines = explode("\n", $reportData);

        foreach ($lines as $line) {
            if (strlen($line) > 2) {
                $dataArray[] = str_getcsv($line);
            }
        }

        return collect($dataArray);
    }
}
