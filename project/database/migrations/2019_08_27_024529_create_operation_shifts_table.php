<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOperationShiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operation_shifts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('operation_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('role_type_id')->nullable();
            $table->unsignedBigInteger('role_competency_id')->nullable();
            $table->unsignedBigInteger('location_id')->nullable();
            $table->unsignedBigInteger('powered_locomotive_id')->nullable();
            $table->unsignedBigInteger('steam_locomotive_id')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            // Cascades as their deletion would invalidate the shift
            $table->foreign('operation_id')->references('id')->on('operations')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('role_type_id')->references('id')->on('role_types')->onDelete('cascade');

            // Nullable as these can be seen as optional information
            $table->foreign('role_competency_id')->references('id')->on('role_competencies')->onDelete('set null');
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('set null');
            $table->foreign('powered_locomotive_id')->references('id')->on('powered_locomotives')->onDelete('set null');
            $table->foreign('steam_locomotive_id')->references('id')->on('steam_locomotives')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('operation_shifts');
    }
}
