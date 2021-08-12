<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBigLeaveClaimsTable extends Migration
{
    public function up()
    {
        Schema::create('big_leave_claims', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('big_leave_id')->index('big_leave_id');
            $table->unsignedBigInteger('user_id')->index('user_id');
            $table->unsignedInteger('site_id')->index('site_id');			
			$table->string('number');
			$table->year('year');
			$table->float('idr',13,2)->nullable();
			$table->enum('multiplier_salary', ['1','2'])->default(NULL);
            $table->enum('head_approv', ['0', '1','2'])->default('0');
            $table->enum('hrd_approv', ['0', '1','2'])->default('0');		
            $table->enum('sm_approv', ['0', '1','2'])->default('0');
			$table->enum('approv', ['0', '1','2'])->default('0');
			$table->enum('paid', ['0', '1'])->default('0');		
            $table->enum('active', ['0', '1'])->default('1');
            $table->foreign('big_leave_id')->references('id')->on('big_leaves')->onDelete('no action');
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
        Schema::dropIfExists('big_leave_claims');
    }
}
