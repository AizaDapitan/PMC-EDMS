<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDowntimeFlatDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('downtime_flatdata', function (Blueprint $table) {
            $table->id();
            $table->integer('unit_id');
            $table->integer('downtime_id');
            $table->integer('mins');
            $table->text('remarks')->nullable();;
            $table->integer('is_scheduled');
            $table->timestamp('date')->default(\DB::raw('CURRENT_TIMESTAMP'))->nullable();
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
        Schema::dropIfExists('downtime_flatdata');
    }
}
