<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name', 45);
            $table->timestamps();
        });
        Schema::table('events', function (Blueprint $table) {
            $table->unsignedBigInteger('statuses_id')->nullable();
            $table->foreign('statuses_id')->references('id')->on('event_statuses');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropForeign('event_statuses_id_foreign');
            $table->dropColumn('statuses_id');
        });
        Schema::dropIfExists('event_statuses');
    }
};
