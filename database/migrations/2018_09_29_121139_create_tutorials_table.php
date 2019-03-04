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
            $table->string('description');
            $table->text('steps');
            $table->string('path');
            $table->string('query')->nullable();
            $table->string('project_id');

            $table->timestamps();
            $table->softDeletes();

            $table->primary('id');
            $table->index(['project_id', 'path'], 'idx_project_id_path');
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
