<?php

use App\Models\Adwords\AdwordsData;
use Carbon\Carbon;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(AdwordsData::class, function (Faker\Generator $faker) {
    return [
        'report_date' => '2019-12-11',
        'ad_group_id' => $faker->randomNumber(),
        'campaign_id' => $faker->randomNumber(),
        'creative_id' => $faker->randomNumber(),
        'impressions' => $faker->randomNumber(),
        'clicks' => $faker->numberBetween(0, 5617),
        'cost' => $faker->randomFloat(),
        'client_adwords_id' => $faker->randomNumber(),
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ];
});
