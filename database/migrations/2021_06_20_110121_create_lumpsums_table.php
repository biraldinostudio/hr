<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLumpsumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lumpsums', function (Blueprint $table) {
            $table->increments('id')->index('lump_id');
            $table->unsignedInteger('site_id')->index('site_id');
            $table->unsignedInteger('poh_id')->index('poh_id');
            $table->unsignedInteger('position_id')->index('pos_id');
            $table->float('idr',13,2)->default(NULL);
            $table->float('idr_staff',13,2)->default(NULL);			
            $table->enum('active', ['0', '1'])->default('1');
            $table->foreign('site_id')->references('id')->on('sites')->onDelete('no action');
            $table->foreign('poh_id')->references('id')->on('pohs')->onDelete('no action'); 
            $table->foreign('position_id')->references('id')->on('positions')->onDelete('no action'); 
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
        Schema::dropIfExists('lumpsums');
        Schema::enableForeignKeyConstraints();
    }
}
