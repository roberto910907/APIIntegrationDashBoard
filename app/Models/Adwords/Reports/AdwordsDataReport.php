<?php

namespace App\Models\Adwords\Reports;

use Exception;
use Google\AdsApi\AdWords\Reporting\v201809\DownloadFormat;
use Google\AdsApi\AdWords\Reporting\v201809\ReportDefinition;
use Google\AdsApi\AdWords\Reporting\v201809\ReportDefinitionDateRangeType;
use Google\AdsApi\AdWords\Reporting\v201809\ReportDownloader;
use Google\AdsApi\AdWords\v201809\cm\ApiException;
use Google\AdsApi\AdWords\v201809\cm\DateRange;
use Google\AdsApi\AdWords\v201809\cm\ReportDefinitionReportType;
use Google\AdsApi\AdWords\v201809\cm\Selector;
use Illuminate\Console\Command;
use Illuminate\Database\QueryException;

class AdwordsDataReport extends ProcessorReportAbstract
{
    use ManufactureTrait;

    /**
     * @var Command
     */
    private $console;

    /**
     * @var ManufactureReportConsolidateRepositoryInterface
     */
    private $manufactureReportConsolidateRepository;

    /**
     * @param string $name
     * @param ManufactureReportConsolidateRepositoryInterface $manufactureReportConsolidateRepository
     */
    public function __construct(
        string $name,
        ManufactureReportConsolidateRepositoryInterface $manufactureReportConsolidateRepository
    ) {
        parent::__construct($name);
        $this->manufactureReportConsolidateRepository = $manufactureReportConsolidateRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function run(Command $console): void
    {
        $this->console = $console;

        $data = $this->getData();

        if ('' === trim($data)) {
            $this->console->info('[' . now()->toDateTimeString() . '] No LogTemplate data!');

            return;
        }

        $this->insertDataToDb(Processor::processReportDefinition($data));
    }

    /**
     * Get a performance report.
     *
     * @method getAccountPerformaceReport
     *
     * @return string
     * @throws ApiException
     */
    private function getData(): string
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

        $selector->setDateRange(
            new DateRange(
                $this->config->getRange()['start']->format('Ymd'),
                $this->config->getRange()['end']->format('Ymd')
            )
        );

        // Create report definition.
        $reportDefinition = new ReportDefinition();
        $reportDefinition->setSelector($selector);
        $reportDefinition->setReportName('GMLog Template Report #' . uniqid('report', true));
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
     * @throws \Google\AdsApi\AdWords\v201809\cm\ApiException
     */
    protected function getDownloadData(ReportDefinition $reportDefinition): string
    {
        return (new ReportDownloader($this->config->getSession()))->downloadReport($reportDefinition)->getAsString();
    }

    /**
     *
     * @param array $data An array of account data
     *
     * @throws QueryException
     * @throws Exception
     */
    private function insertDataToDb($data): void
    {
        $items = collect($data)->map(function ($item) {
            $extra = [
                'placement_id' => 0,
                'site_id' => 0,
            ];
            $data = [
                'campaign_name' => $item[3], // As Creative_id
                'report_date' => $item[0],
                'campaign_id' => $item[2],
                'account_id' => $this->config->getClientId(),
                'account_name' => $item[1], // As Ad_Group_Id
                'provider' => GMReportLookup::GOOGLE_PROVIDER,
                'spend' => (float) ($item[5] / 1000000),
                'impressions' => $item[4],
                'report_type' => ProcessorInterface::LOGS_REPORT_TYPE,
                'extra' => json_encode($extra),
            ];

            return array_merge($data, $this->setDefaultFieldsConsolidation());
        });

        try {
            $this->manufactureReportConsolidateRepository->insertBulkCollection($items);
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            throw new \RuntimeException($e->getCode());
        }
    }
}
