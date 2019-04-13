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
            $table->longText('trigger_target')->nullable()->default(null);
            $table->string('trigger_event');
            $table->unsignedInteger('waiting_time')->default(0);
            $table->longText('config');
            $table->string('tutorial_id');

            $table->timestamps();
            $table->softDeletes();

            $table->primary('id');
            $table->index('tutorial_id', 'idx_tutorial_id');
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
