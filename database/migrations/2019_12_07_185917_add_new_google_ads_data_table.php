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

            // Date fields
            $table->timestamps();
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::drop('google_adwords_data');
    }
}
