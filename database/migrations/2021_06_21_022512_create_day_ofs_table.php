<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDayOfsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('day_ofs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index('user_id');
            $table->unsignedInteger('site_id')->index('site_id');
            $table->unsignedInteger('poh_id')->index('poh_id');
			$table->string('number');
            $table->date('start');
            $table->date('end');
            $table->date('in');
            $table->date('in_before');
            $table->integer('work_day');			
            $table->date('annual_leave_start')->default(NULL)->nullable();
            $table->date('annual_leave_end')->default(NULL)->nullable();		
            $table->integer('annual_leave')->default(NULL)->nullable();
            $table->date('big_leave_start')->default(NULL)->nullable();
            $table->date('big_leave_end')->default(NULL)->nullable();		
            $table->integer('big_leave')->default(NULL)->nullable();			
            $table->integer('day_of_sum');
            $table->integer('day_of_total');
			$table->integer('day_of_grandtotal');
			$table->integer('day_of_standart')->nullable();
			$table->integer('day_of_should')->nullable();			
			$table->integer('day_of_less')->nullable();
			$table->integer('annual_leave_standart')->nullable();
			$table->integer('annual_leave_should')->nullable();			
			$table->integer('annual_leave_less')->nullable();
			$table->integer('big_leave_standart')->nullable();
			$table->integer('big_leave_should')->nullable();			
			$table->integer('big_leave_less')->nullable();
            $table->date('travel_from_go')->nullable();
            $table->date('travel_to_go')->nullable();
            $table->date('travel_from_back')->nullable();
            $table->date('travel_to_back')->nullable();
			$table->date('ticket_from_go')->nullable();	
			$table->date('ticket_from_back')->nullable();	
			$table->time('ticket_time_go')->nullable();	
			$table->time('ticket_time_back')->nullable();	
            $table->integer('travel_day')->nullable();
            $table->integer('ticket_day')->nullable();
            $table->integer('travel_day_go')->nullable();
            $table->integer('travel_day_back')->nullable();			
            $table->text('description')->nullable();
            $table->float('lumpsum',13,2);
            $table->enum('head_approv', ['0', '1','2'])->default(NULL);
            $table->enum('sm_approv', ['0', '1','2'])->default(NULL);
            $table->enum('hrd_approv', ['0', '1','2'])->default(NULL);
			$table->enum('approv', ['0', '1','2','3'])->default('0');
			$table->integer('update_count')->nullable();	
            $table->enum('active', ['0', '1'])->default('1');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('no action');
            $table->foreign('site_id')->references('id')->on('sites')->onDelete('no action');
            $table->foreign('poh_id')->references('id')->on('pohs')->onDelete('no action');
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
        Schema::dropIfExists('day_ofs');
        Schema::enableForeignKeyConstraints();
    }
}
