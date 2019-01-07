<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->string('id')->unique();
            $table->string('name');
            $table->string('protocol');
            $table->string('domain');
            $table->timestamps();
            $table->softDeletes();
            $table->string('user_id');

            $table->primary('id');
            $table->unique(['domain', 'user_id']);

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
        Schema::dropIfExists('projects');
    }
}
