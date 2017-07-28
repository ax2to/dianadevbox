<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIssueAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issue_attachments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('issue_id');
            $table->string('filename');
            $table->string('path');
            $table->string('mime');
            $table->string('size');
            $table->string('extension');
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
        Schema::dropIfExists('issue_attachments');
    }
}
