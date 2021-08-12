<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignmentDestinationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignment_destinations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('assignment_id')->index('assignment_id');
			$table->unsignedInteger('from_id')->index('from_id');
			$table->unsignedInteger('to_id')->index('to_id');
            $table->enum('type', ['Go', 'Back'])->default(NULL);
			$table->enum('destination', ['Ticket', 'Travel'])->default(NULL);
            $table->enum('active', ['0', '1'])->default('1');
            $table->foreign('assignment_id')->references('id')->on('assignments')->onDelete('no action');
            $table->foreign('from_id')->references('id')->on('destinations')->onDelete('no action'); 
            $table->foreign('to_id')->references('id')->on('destinations')->onDelete('no action'); 			
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
        Schema::dropIfExists('assignment_destinations');
    }
}
