<?php

use App\Models\Issue\StatusModel;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIssuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issues', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id');
            $table->integer('type_id');
            $table->string('summary');
            $table->text('description');
            $table->integer('priority_id');
            $table->integer('status_id')->default(StatusModel::DEFAULT);
            $table->integer('assign_to');
            $table->integer('reported_by');
            $table->integer('resolution_id')->nullable();
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
        Schema::dropIfExists('issues');
    }
}