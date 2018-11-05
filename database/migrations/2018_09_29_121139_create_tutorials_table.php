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
            $table->string('url');
            $table->string('site_id');
            $table->timestamps();
            $table->softDeletes();

            $table->primary('id');
            $table->index(['site_id', 'url'], 'idx_site_id_url');
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
