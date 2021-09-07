<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('tag')->nullable();
            $table->string('asset_type')->nullable();
            $table->text('description')->nullable();
            $table->string('manufacturer')->nullable();
            $table->string('model')->nullable();
            $table->string('serial')->nullable();
            $table->integer('year_manufactured')->nullable();
            $table->timestamp('commissioning_date')->nullable();
            $table->string('site')->nullable();
            $table->string('location')->nullable();
            $table->string('condition')->nullable();
            $table->string('status')->nullable();
            $table->string('vendor')->nullable();
            $table->string('po_reference')->nullable();
            $table->decimal('po_value')->nullable();
            $table->integer('is_deleted')->nullable();
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
        Schema::dropIfExists('assets');
    }
}
