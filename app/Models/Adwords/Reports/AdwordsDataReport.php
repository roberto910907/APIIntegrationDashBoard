<?php

declare(strict_type=1);

namespace App\Models\Adwords\Reports;

use App\Models\Adwords\Config\Config;
use Carbon\Carbon;
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
     * @return Collection
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
     * @return Config
     */
    public function getConfig(): Config
    {
        return $this->config;
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
            if (strlen($line) < 2) {
                continue;
            }

            $lineAsArray = str_getcsv($line);

            $dataArray[] = [
                'report_date' => $lineAsArray[0],
                'ad_group_id' => (int) $lineAsArray[1],
                'campaign_id' => (int) $lineAsArray[2],
                'creative_id' => (int) $lineAsArray[3],
                'impressions' => (int) $lineAsArray[4],
                'clicks' => (int) $lineAsArray[5],
                'cost' => (double) ($lineAsArray[6] / 1000000),
                'client_adwords_id' => $this->getConfig()->getClientId(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        return collect($dataArray);
    }

    /**
     * @throws ApiException
     *
     * @return string
     */
    protected function getReportData(): string
    {
        // Create Selector.
        $selector = new Selector();
        $selector->setFields([
            'Date',
            'AdGroupId',
            'CampaignId',
            'CreativeId',
            'Impressions',
            'Clicks',
            'Cost',
        ]);

        $selector->setDateRange(new DateRange('20191206', '20191207'));

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
     * @throws ApiException
     *
     * @return string
     */
    protected function getDownloadData(ReportDefinition $reportDefinition): string
    {
        return (new ReportDownloader($this->config->getSession()))->downloadReport($reportDefinition)->getAsString();
    }
}
