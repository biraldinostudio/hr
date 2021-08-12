<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionDebtsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permission_debts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('permission_id')->index('permission_id');			
            $table->unsignedBigInteger('user_id')->index('user_id');
            $table->unsignedInteger('site_id')->index('site_id');
            $table->year('year');			
            $table->date('date');
            $table->integer('sum_day');				
            $table->integer('less_day');
            $table->enum('for', ['DayOf', 'AnnualLeave','BigLeave','BasicSalary'])->default(NULL);				
            $table->enum('approv', ['0', '1','2'])->default('0');            
			$table->enum('active', ['0', '1'])->default('1');
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('no action');			
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
        Schema::dropIfExists('permission_debts');
    }
}
