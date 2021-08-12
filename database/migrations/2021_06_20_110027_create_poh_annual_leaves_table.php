<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePohAnnualLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('poh_annual_leaves', function (Blueprint $table) {
            $table->increments('id')->index('ann_lvs_id');
            $table->unsignedInteger('site_id')->index('site_id');
            $table->unsignedInteger('poh_id')->index('poh_id');
            $table->integer('day_of');
            $table->enum('active', ['0', '1'])->default('1');
            $table->foreign('site_id')->references('id')->on('sites')->onDelete('no action');
            $table->foreign('poh_id')->references('id')->on('pohs')->onDelete('no action');
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
        Schema::dropIfExists('poh_annual_leaves');
    }
}
