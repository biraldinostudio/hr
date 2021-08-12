<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnnualLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('annual_leaves', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index('user_id');
            $table->unsignedInteger('site_id')->index('site_id');
            $table->unsignedInteger('poh_id')->index('poh_id');
			$table->unsignedBigInteger('day_of_id')->index('day_of_id');
			$table->year('year');			
            $table->date('start');
            $table->date('end');
            $table->integer('sum')->default(NULL)->nullable();
			$table->integer('standart')->nullable();
			$table->integer('should')->nullable();			
			$table->integer('less')->nullable();
			$table->integer('less_before')->nullable();			
			$table->enum('approv', ['0', '1','2','3'])->default('0');
			$table->enum('revision', ['0', '1'])->default('0');
            $table->enum('active', ['0', '1'])->default('1');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('no action');
            $table->foreign('site_id')->references('id')->on('sites')->onDelete('no action');
            $table->foreign('poh_id')->references('id')->on('pohs')->onDelete('no action');
			$table->foreign('day_of_id')->references('id')->on('day_ofs')->onDelete('no action');
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
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('annual_leaves');
        Schema::enableForeignKeyConstraints();
    }
}
