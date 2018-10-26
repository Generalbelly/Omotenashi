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
            $table->string('id');
            $table->string('name');
            $table->string('description');
            $table->text('steps');
            $table->string('path');
            $table->string('site_id');
            $table->timestamps();
            $table->softDeletes();

            $table->primary('id');
            $table->index(['site_id', 'path'], 'idx_site_id_path');
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
