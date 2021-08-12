<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBigLeaveCountersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('big_leave_counters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index('user_id');
            $table->unsignedInteger('site_id')->index('site_id');
			$table->year('year');
            $table->integer('day')->default(NULL)->nullable();				
			$table->integer('standart')->nullable();
			$table->integer('should')->nullable();
			$table->integer('less')->nullable();
			$table->integer('less_before')->nullable();
			$table->date('first_date');
            $table->date('last_date');
						$table->enum('revision', ['0', '1'])->default('0');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('no action');
            $table->foreign('site_id')->references('id')->on('sites')->onDelete('no action');
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
        Schema::dropIfExists('big_leave_counters');
    }
}
