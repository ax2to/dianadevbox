<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('worklogs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('issue_id');
            $table->integer('user_id');
            $table->string('worked');
            $table->dateTime('date');
            $table->text('description');
            $table->boolean('in_progress')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('worklogs');
    }
}
