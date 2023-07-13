<?php

namespace Database\Migrations;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'dictionary_schools';

    /**
     * Run the migrations.
     * @table dictionary_schools
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name', 45)->nullable()->default(null);
            $table->string('city', 45)->nullable()->default(null);
            $table->string('street', 45)->nullable()->default(null);
            $table->integer('no_building')->nullable()->default(null);
            $table->string('zip_code', 45)->nullable()->default(null);
            $table->integer('dictionary_sources_id')->unsigned();
            $table->timestamps();

            $table->index(["dictionary_sources_id"]);


            $table->foreign('dictionary_sources_id')
                ->references('id')->on('dictionary_sources')
                ->onDelete('no action')
                ->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->tableName);
    }
};
