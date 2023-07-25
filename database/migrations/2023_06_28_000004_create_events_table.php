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
    public $tableName = 'events';

    /**
     * Run the migrations.
     * @table events
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name', 45)->nullable()->default(null);
            $table->string('shortcut', 45)->nullable()->default(null);
            $table->string('city', 45)->nullable()->default(null);
            $table->string('street', 45)->nullable()->default(null);
            $table->string('zip_code', 45)->nullable()->default(null);
            $table->integer('no_building')->nullable()->default(null);
            $table->integer('no_room')->nullable()->default(null);
            $table->string('location_shortcut', 45)->nullable()->default(null);
            $table->text('description')->nullable()->default(null);
            $table->dateTime('date_start')->nullable()->default(null);
            $table->dateTime('date_end')->nullable()->default(null);
            $table->dateTime('date_start_publi')->nullable()->default(null);
            $table->dateTime('date_end_publi')->nullable()->default(null);
          
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable()->default(null);

           
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
