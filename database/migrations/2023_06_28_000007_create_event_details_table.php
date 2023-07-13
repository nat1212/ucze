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
    public $tableName = 'event_details';

    /**
     * Run the migrations.
     * @table event_details
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('speaker_first_name', 45)->nullable()->default(null);
            $table->string('speaker_last_name', 45)->nullable()->default(null);
            $table->string('title', 45)->nullable()->default(null);
            $table->dateTime('date_start')->nullable()->default(null);
            $table->dateTime('date_end')->nullable()->default(null);
            $table->text('description')->nullable()->default(null);
            $table->text('comments')->nullable()->default(null);
            $table->integer('number_seats')->nullable();
            $table->integer('events_id')->unsigned();
            $table->timestamps();

            $table->index(["events_id"]);


            $table->foreign('events_id')
                ->references('id')->on('events');
                
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
