<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFirstVisitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('first_visits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('patient_name');
            $table->integer('recorded_by');
            $table->string('tb_by_sputum')->nullable();
            $table->string('tb_by_x_ray')->nullable();
            $table->string('hospitalisation')->nullable();
            $table->string('death')->nullable();
            $table->string('loss_to_follow_up')->nullable();
            $table->string('non')->nullable();
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
        Schema::dropIfExists('first_visits');
    }
}
