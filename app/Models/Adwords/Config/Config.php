<?php

namespace App\Models\Adwords\Config;

use Google\AdsApi\AdWords\AdWordsSession;
use Google\AdsApi\Common\AdsSession;

class Config
{
    /**
     * @var AdWordsSession
     */
    protected $session;

    /**
     * @var array
     */
    protected $range;

    /**
     * @var int
     */
    protected $clientId;

    /**
     * @param int $clientId The client id
     *
     * @return self
     */
    public function setClientId(int $clientId): self
    {
        $this->clientId = $clientId;

        return $this;
    }

    /**
     * @param array $range An array of Carbon objects
     *
     * @return self
     */
    public function setRange(array $range): self
    {
        $this->range = $range;

        return $this;
    }

    /**
     * @param AdsSession $session
     *
     * @return self
     */
    public function setSession(AdsSession $session): self
    {
        $this->session = $session;

        return $this;
    }

    /**
     *
     * @return int
     */
    public function getClientId(): int
    {
        return $this->clientId;
    }

    /**
     * @method getRange
     *
     * @return array
     */
    public function getRange(): array
    {
        return $this->range;
    }

    /**
     * @return AdWordsSession
     */
    public function getSession(): AdWordsSession
    {
        return $this->session;
    }
}
