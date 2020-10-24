<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSecondVisitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('second_visits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('recorded_by');
            $table->string('patient_name');
            $table->string('tb_by_sputum')->nullable();
            $table->string('tb_by_x-ray')->nullable();
            $table->string('hospitalisations')->nullable();
            $table->string('deaths')->nullable();
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
        Schema::dropIfExists('second_visits');
    }
}
