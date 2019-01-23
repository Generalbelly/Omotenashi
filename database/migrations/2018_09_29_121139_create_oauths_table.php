<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOAuthsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oauths', function (Blueprint $table) {
            $table->string('id')->unique();
            $table->string('service');
            $table->string('email');
            $table->string('access_token');
            $table->string('refresh_token');
            $table->string('project_id');

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
        Schema::dropIfExists('oauths');
    }
}
