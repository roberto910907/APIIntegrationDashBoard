<?php

namespace App\Models\Adwords\Session;

use Google\AdsApi\AdWords\AdWordsSession;
use Google\AdsApi\AdWords\AdWordsSessionBuilder;
use Google\AdsApi\AdWords\ReportSettingsBuilder;
use Google\AdsApi\Common\ConfigurationLoader;
use Google\AdsApi\Common\OAuth2TokenBuilder;

class Session
{
    /**
     * @param int $clientId
     *
     * @return AdWordsSession
     */
    public static function create(int $clientId): AdWordsSession
    {
        $configFilePath = base_path() . '/adsapi_php.ini';

        $configuration = (new ConfigurationLoader())->fromFile($configFilePath);

        // Generate a refreshable OAuth2 credential for authentication.
        $oAuth2Credential = (new OAuth2TokenBuilder())
            ->from($configuration)
            ->build();

        $reportSettings = (new ReportSettingsBuilder())
            ->from($configuration)
            ->includeZeroImpressions(false)
            ->build();

        return (new AdWordsSessionBuilder())
            ->from($configuration)
            ->withClientCustomerId($clientId)
            ->withOAuth2Credential($oAuth2Credential)
            ->withReportSettings($reportSettings)
            ->build();
    }
}
