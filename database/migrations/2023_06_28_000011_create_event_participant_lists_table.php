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
    public $tableName = 'event_participant_lists';

    /**
     * Run the migrations.
     * @table event_participant_lists
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('first_name', 45)->nullable()->default(null);
            $table->string('last_name', 45)->nullable()->default(null);
            $table->integer('event_users_id')->unsigned();
            $table->timestamps();

            $table->index(["event_users_id"]);


            $table->foreign('event_users_id')
                ->references('id')->on('event_users')
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
