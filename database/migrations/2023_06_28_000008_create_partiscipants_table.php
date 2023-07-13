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
    public $tableName = 'participants';

    /**
     * Run the migrations.
     * @table partycipants
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
            $table->string('email', 45)->nullable()->default(null);
            $table->string('password', 45)->nullable()->default(null);
            $table->string('sex', 45)->nullable()->default(null);
            $table->date('birth_date')->nullable()->default(null);
            $table->string('idu_create', 45)->nullable()->default(null);
            $table->string('idu_mod', 45)->nullable()->default(null);
            $table->string('idu_delete', 45)->nullable()->default(null);
            $table->integer('dictionary_schools_id')->unsigned()->nullable()->default(null);;
            $table->timestamps();

            $table->index(["dictionary_schools_id"]);


            $table->foreign('dictionary_schools_id')
                ->references('id')->on('dictionary_schools')
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
