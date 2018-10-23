<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGAOAuthsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ga_oauths', function (Blueprint $table) {
            $table->string('id');
            $table->string('email');
            $table->string('access_token');
            $table->string('refresh_token');

            $table->timestamps();
            $table->softDeletes();

            $table->primary('id');
            $table->index('id', 'idx_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ga_oauths');
    }
}
