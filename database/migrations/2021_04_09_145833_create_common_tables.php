<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCommonTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->engine = 'MyISAM';

            $table->id();
            $table->string('number');
            $table->string('number_search');

            $table->index('number_search');
        });

        Schema::create('original_codes', function (Blueprint $table) {
            $table->engine = 'MyISAM';

            $table->id();
            $table->unsignedBigInteger('article_id')->nullable();
            $table->string('value');
            $table->string('value_search');

            $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');
            $table->index('value_search');
        });

        Schema::create('related_numbers', function (Blueprint $table) {
            $table->engine = 'MyISAM';

            $table->id();
            $table->unsignedBigInteger('article_id')->nullable();
            $table->string('value');
            $table->string('value_search');

            $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');
            $table->index('value_search');
        });

        Schema::create('eans', function (Blueprint $table) {
            $table->engine = 'MyISAM';

            $table->id();
            $table->unsignedBigInteger('article_id')->nullable();
            $table->string('value');
            $table->string('value_search');

            $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');
            $table->index('value_search');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eans');
        Schema::dropIfExists('related_numbers');
        Schema::dropIfExists('original_codes');
        Schema::dropIfExists('articles');
    }
}
