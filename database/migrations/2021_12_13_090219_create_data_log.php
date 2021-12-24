<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_logs', function (Blueprint $table) {
            $table->id();
            $table->string('api_key')->nullable();
            $table->string('line')->nullable();
            $table->datetime('downtime')->nullable();
            $table->datetime('uptime')->nullable();
            $table->bigInteger('category_id')->nullable()->unsigned();
            $table->text('description')->nullable();
            $table->bigInteger('assigned_by')->nullable()->unsigned();
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('data_logs');
    }
}
