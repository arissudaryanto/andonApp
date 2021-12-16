<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataLogHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_log_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('data_log_id')->nullable()->unsigned();
            $table->text('remark')->nullable();
            $table->bigInteger('created_by')->nullable()->unsigned();
            $table->string('file_attachment')->nullable();
            $table->integer('status')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_log_histories');
    }
}
