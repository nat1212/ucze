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
    public $tableName = 'event_services';

    /**
     * Run the migrations.
     * @table event_services
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->dateTime('date_start')->nullable()->default(null);
            $table->dateTime('date_end')->nullable()->default(null);
            $table->integer('users_role_dictionary_id')->unsigned();
            $table->integer('events_id')->unsigned();
            $table->integer('users_id')->unsigned();
            $table->timestamps();

            $table->index(["users_role_dictionary_id"]);

            $table->index(["events_id"]);

            $table->index(["users_id"]);

        
            $table->foreign('users_role_dictionary_id')
                ->references('id')->on('users_role_dictionary');
               
            
            $table->foreign('events_id')
                ->references('id')->on('events');
              

            $table->foreign('users_id')
                ->references('id')->on('users');
                
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
