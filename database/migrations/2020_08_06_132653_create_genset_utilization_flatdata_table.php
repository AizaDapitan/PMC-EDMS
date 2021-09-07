<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGensetUtilizationFlatdataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('genset_utilization_flatdata', function (Blueprint $table) {
            $table->id();
            $table->timestamp('date')->default(\DB::raw('CURRENT_TIMESTAMP'))->nullable();
            $table->integer('mins')->nullable();
            $table->integer('unit_id')->nullable();
            $table->decimal('fuel', 10, 2)->nullable();
            $table->decimal('kwh', 10, 2)->nullable();
            $table->integer('downtime_id')->nullable();
            $table->string('remarks')->nullable();
            $table->decimal('run_start', 10, 2)->nullable();
            $table->decimal('run_stop', 10, 2)->nullable();            
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
        Schema::dropIfExists('genset_utilization_flatdata');
    }
}
