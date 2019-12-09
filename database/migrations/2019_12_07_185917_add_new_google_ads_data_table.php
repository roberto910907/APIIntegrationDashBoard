<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewGoogleAdsDataTable extends Migration
{
    /**
     * @return void
     */
    public function up(): void
    {
        Schema::create('google_adwords_data', function (Blueprint $table) {
            // Table fields
            $table->bigIncrements('id');
            $table->dateTime('report_date');
            $table->bigInteger('ad_group_id');
            $table->bigInteger('campaign_id');
            $table->bigInteger('creative_id');
            $table->integer('impressions');
            $table->integer('clicks');
            $table->double('cost');
            $table->bigInteger('client_adwords_id');

            // Date fields
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('google_adwords_data');
    }
}
