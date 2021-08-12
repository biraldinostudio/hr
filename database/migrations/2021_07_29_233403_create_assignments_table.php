<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index('user_id');
            $table->unsignedInteger('site_id')->index('site_id');
			$table->string('number');
            $table->date('start_date');
            $table->date('end_date');
            $table->date('in_date');		
            $table->integer('sum_day');
			$table->date('ticket_date_from_go')->nullable();	
			$table->date('ticket_date_from_back')->nullable();	
			$table->time('ticket_time_from_go')->nullable();	
			$table->time('ticket_time_from_back')->nullable();
            $table->date('travel_date_from_go')->nullable();
            $table->date('travel_date_from_back')->nullable();		
            $table->text('description');
            $table->enum('location', ['inSite', 'inRegional','outRegional'])->default(NULL);			
            $table->float('lodging_cost',13,2)->nullable();
            $table->float('transportation_cost',13,2)->nullable();
            $table->float('meal_cost',13,2)->nullable();
            $table->float('other_cost',13,2)->nullable();
            $table->integer('lodging_day')->nullable();
            $table->integer('transportation_day')->nullable();
            $table->integer('meal_day')->nullable();
            $table->integer('other_day')->nullable();
            $table->enum('head_approv', ['0', '1','2'])->default(NULL);
            $table->enum('sm_approv', ['0', '1','2'])->default(NULL);
            $table->enum('hrd_approv', ['0', '1','2'])->default(NULL);
			$table->enum('approv', ['0', '1','2','3'])->default('0');	
            $table->enum('active', ['0', '1'])->default('1');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('no action');
            $table->foreign('site_id')->references('id')->on('sites')->onDelete('no action');
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
        Schema::dropIfExists('assignments');
    }
}
