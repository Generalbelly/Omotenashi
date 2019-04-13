<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTutorialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tutorials', function (Blueprint $table) {
            $table->string('id')->unique();
            $table->string('name');
            $table->string('description')->nullable()->default(null);
            $table->string('operator');
            $table->string('depth');
            $table->string('path');
            $table->json('parameters');
            $table->json('settings');
            $table->string('is_active', 3)->default('no');
            $table->json('last_time_used_at');

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
        Schema::dropIfExists('tutorials');
    }
}
