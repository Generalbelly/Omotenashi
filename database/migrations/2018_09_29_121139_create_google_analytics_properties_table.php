<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoogleAnalyticsPropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('google_analytics_properties', function (Blueprint $table) {
            $table->string('id')->unique();
            $table->string('account_id');
            $table->string('account_name');
            $table->string('property_id');
            $table->string('property_name');
            $table->string('website_url');
            $table->string('project_id');

            $table->timestamps();
            $table->softDeletes();

            $table->primary('id');
            $table->index('project_id', 'idx_project_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('google_analytics_properties');
    }
}
