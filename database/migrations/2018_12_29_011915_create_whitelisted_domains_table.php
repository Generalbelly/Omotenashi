<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWhitelistedDomainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('whitelisted_domains', function (Blueprint $table) {
            $table->string('id')->unique();
            $table->string('protocol');
            $table->string('domain');
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
        Schema::dropIfExists('whitelisted_domains');
    }
}
