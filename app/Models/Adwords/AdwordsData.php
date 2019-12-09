<?php

namespace App\Models\Adwords;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdwordsData extends Model
{
    use SoftDeletes;

    protected $table = 'google_adwords_data';

    protected $fillable = [
        'report_date',
        'ad_group_id',
        'campaign_id',
        'creative_id',
        'impressions',
        'clicks',
        'cost',
        'client_adwords_id',
    ];

    protected $dates = [
        'deleted_at',
        'created_at',
        'updated_at',
    ];
}
