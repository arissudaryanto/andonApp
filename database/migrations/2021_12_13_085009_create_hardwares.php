<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHardwares extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hardwares', function (Blueprint $table) {
            $table->id();
            $table->string('device_id')->nullable();
            $table->bigInteger('area_id')->nullable()->unsigned();
            $table->string('name')->nullable();
            $table->string('type')->nullable();
            $table->string('light')->nullable()->default('GREEN');
            $table->string('image_url')->nullable();
            $table->text('description')->nullable();
            $table->boolean('status')->nullable()->default(false);
            $table->datetime('downtime')->nullable();
            $table->datetime('uptime')->nullable();
            $table->bigInteger('created_by')->nullable()->unsigned();
            $table->bigInteger('updated_by')->nullable()->unsigned();
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
        Schema::dropIfExists('hardwares');
    }
}
