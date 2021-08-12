<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('site_id')->index('site_id');
            $table->unsignedInteger('poh_id')->index('poh_id');
            $table->unsignedInteger('position_id')->index('pos_id');
            $table->string('nrp',20)->unique();
            $table->string('ktp',16);
            $table->string('name',100);
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->string('place_of_birth',100)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->date('join_date');
            $table->enum('religion', ['Katolik', 'Protestan','Islam','Hindu','Buddha','Khonghucu'])->default('Katolik');            
            $table->string('blood_type',10)->nullable();
            $table->text('address')->nullable();
			$table->string('phone',26)->nullable();
            $table->enum('staff', ['0', '1'])->default('0');
            $table->enum('employee', ['0', '1'])->default('0');
			$table->enum('home_facilities', ['0', '1'])->default('0');
			$table->float('lumpsum',13,2);
            $table->enum('lumpsum_status', ['0', '1'])->default('0'); 
            $table->enum('level', ['administrator', 'hrd_admin','hrd_head','site_manager','department_head','employee'])->default('employee');
            $table->enum('hr_head', ['0', '1'])->default('0'); 
			$table->enum('active', ['0', '1'])->default('1');
            $table->foreign('site_id')->references('id')->on('sites')->onDelete('no action');
            $table->foreign('poh_id')->references('id')->on('pohs')->onDelete('no action'); 
            $table->foreign('position_id')->references('id')->on('positions')->onDelete('no action');
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
        Schema::dropIfExists('users');
        Schema::enableForeignKeyConstraints();
    }
}
