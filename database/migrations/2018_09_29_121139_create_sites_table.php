<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sites', function (Blueprint $table) {
            $table->string('id');
            $table->string('name');
            $table->string('domain');
            $table->timestamps();
            $table->softDeletes();
            $table->string('user_id');

            $table->primary('id');
            $table->index('id', 'idx_id');

            $table->index(['user_id'], 'idx_user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sites');
    }
}
