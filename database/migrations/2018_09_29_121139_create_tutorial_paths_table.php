<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTutorialPathsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tutorial_paths', function (Blueprint $table) {
            $table->string('ancestor');
            $table->string('descendant');

            $table->timestamps();
            $table->softDeletes();

            $table->primary(['ancestor', 'descendant']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tutorial_paths');
    }
}
