<?php

declare(strict_type=1);

namespace App\Repositories;

use App\Models\Adwords\AdwordsData;
use App\Repositories\Interfaces\CommonRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class AdwordsDataRepository implements CommonRepositoryInterface
{
    use CommonRepository;

    /**
     * @var AdwordsData
     */
    private $adwordsDataModel;

    /**
     * @param AdwordsData $adwordsData
     */
    public function __construct(AdwordsData $adwordsData)
    {
        $this->adwordsDataModel = $adwordsData;
    }

    /**
     * @return Model
     */
    public function getModel(): Model
    {
        return $this->adwordsDataModel;
    }
}
