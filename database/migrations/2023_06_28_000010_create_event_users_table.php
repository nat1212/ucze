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
    public $tableName = 'event_users';

    /**
     * Run the migrations.
     * @table event_participants
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->dateTime('date_report')->nullable()->default(null);
            $table->dateTime('date_approval')->nullable()->default(null);
            $table->dateTime('date_confirmation')->nullable()->default(null);
            $table->integer('number_of_people')->nullable()->default(null);
            $table->string('comments', 45)->nullable()->default(null);
            $table->integer('dictionary_schools_id')->unsigned();
            $table->integer('participants_id')->unsigned();
            $table->integer('events_id')->unsigned();
            $table->integer('event_details_id')->unsigned();
            $table->timestamps();

            $table->index(["dictionary_schools_id"]);

            $table->index(["participants_id"]);

            $table->index(["events_id"]);

            $table->index(["event_details_id"]);


            $table->foreign('dictionary_schools_id')
                ->references('id')->on('dictionary_schools')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('participants_id')
                ->references('id')->on('participants')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('events_id')
                ->references('id')->on('events')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('event_details_id')
                ->references('id')->on('event_details')
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
