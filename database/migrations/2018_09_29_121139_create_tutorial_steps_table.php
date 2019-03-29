<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTutorialStepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tutorial_steps', function (Blueprint $table) {
            $table->string('id')->unique();
            $table->json('path');
            $table->json('parameters');
            $table->string('type');
            $table->longText('content');
            $table->json('trigger');
            $table->string('selector')->nullable()->default(null);

            $table->string('tutorial_id');

            $table->timestamps();
            $table->softDeletes();

            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tutorial_steps');
    }
}
