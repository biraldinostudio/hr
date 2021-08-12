<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePohDayOfsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('poh_day_ofs', function (Blueprint $table) {
            $table->increments('id')->index('poh_days_of_id');
            $table->unsignedInteger('site_id')->index('site_id');
            $table->unsignedInteger('poh_id')->index('poh_id');
            $table->integer('day_of')->nullable();
            $table->integer('travel_day')->nullable();
			$table->integer('travel_day_ticket')->nullable();
            $table->enum('ticket_facilities', ['0', '1'])->default('0');
            $table->enum('travel_day_facilities', ['0', '1'])->default('0');
            $table->enum('lumpsum_facilities', ['0', '1'])->default('0');			
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
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('poh_day_ofs');
        Schema::enableForeignKeyConstraints();
    }
}
