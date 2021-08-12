<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index('user_id');
            $table->unsignedInteger('site_id')->index('site_id');
            $table->unsignedInteger('permission_category_id')->index('permission_category_id');			
			$table->string('number');
            $table->date('start_date');
            $table->date('end_date');
            $table->date('in_date');		
            $table->integer('sum_day');			
            $table->text('description')->nullable();					
            $table->enum('head_approv', ['0', '1','2'])->default(NULL);
            $table->enum('sm_approv', ['0', '1','2'])->default(NULL);
            $table->enum('hrd_approv', ['0', '1','2'])->default(NULL);
			$table->enum('approv', ['0', '1','2','3'])->default('0');	
            $table->enum('active', ['0', '1'])->default('1');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('no action');
            $table->foreign('site_id')->references('id')->on('sites')->onDelete('no action');
            $table->foreign('permission_category_id')->references('id')->on('permission_categories')->onDelete('no action');			
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
        Schema::dropIfExists('permissions');
    }
}
