<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApprovalRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approval_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('doc')->index('doc_id');
            $table->unsignedBigInteger('user_id')->index('user_id');
			$table->tinyText('reason')->nullable();
            $table->enum('level', ['1', '2','3','4','5','6'])->default('1');
            $table->enum('type', ['cuti', 'izin','dinas','training'])->default('cuti');
            $table->enum('active', ['0', '1'])->default('1');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('no action');
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
        Schema::dropIfExists('approval_records');
        Schema::enableForeignKeyConstraints();
    }
}
