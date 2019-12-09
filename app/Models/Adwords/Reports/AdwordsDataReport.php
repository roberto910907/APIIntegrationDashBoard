<?php

declare(strict_type=1);

namespace App\Models\Adwords\Reports;

use App\Models\Adwords\Config\Config;
use Google\AdsApi\AdWords\Reporting\v201809\DownloadFormat;
use Google\AdsApi\AdWords\Reporting\v201809\ReportDefinition;
use Google\AdsApi\AdWords\Reporting\v201809\ReportDefinitionDateRangeType;
use Google\AdsApi\AdWords\Reporting\v201809\ReportDownloader;
use Google\AdsApi\AdWords\v201809\cm\ApiException;
use Google\AdsApi\AdWords\v201809\cm\DateRange;
use Google\AdsApi\AdWords\v201809\cm\ReportDefinitionReportType;
use Google\AdsApi\AdWords\v201809\cm\Selector;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class AdwordsDataReport
{
    /**
     * @var Config
     */
    private $config;

    /**
     * {@inheritdoc}
     */
    public function run(): Collection
    {
        try {
            return $this->processReportResult($this->getReportData());
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());

            return collect();
        }
    }

    /**
     * @param Config $config
     *
     * @return self
     */
    public function setConfig(Config $config): self
    {
        $this->config = $config;

        return $this;
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

    /**
     * @method getAccountPerformaceReport
     *
     * @return string
     * @throws ApiException
     */
    private function getReportData(): string
    {
        // Create Selector.
        $selector = new Selector();
        $selector->setFields([
            'Date',
            'AdGroupId',
            'CampaignId',
            'CreativeId',
            'Impressions',
            'Cost',
        ]);

        $selector->setDateRange(new DateRange('20191201', '20191207'));

        // Create report definition.
        $reportDefinition = new ReportDefinition();
        $reportDefinition->setSelector($selector);
        $reportDefinition->setReportName('Adwords Report #' . uniqid('report', true));
        $reportDefinition->setDateRangeType(ReportDefinitionDateRangeType::CUSTOM_DATE);
        $reportDefinition->setReportType(ReportDefinitionReportType::SEARCH_QUERY_PERFORMANCE_REPORT);
        $reportDefinition->setDownloadFormat(DownloadFormat::CSV);

        return $this->getDownloadData($reportDefinition);
    }

    /**
     * @param ReportDefinition $reportDefinition
     *
     * @return string
     *
     * @throws ApiException
     */
    protected function getDownloadData(ReportDefinition $reportDefinition): string
    {
        return (new ReportDownloader($this->config->getSession()))->downloadReport($reportDefinition)->getAsString();
    }
}
