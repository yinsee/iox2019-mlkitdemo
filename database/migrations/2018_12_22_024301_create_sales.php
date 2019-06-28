<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSales extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->date('date')->unique();
            $table->integer('03000038')->default(0);
            $table->integer('03000045')->default(0);
            $table->integer('03000052')->default(0);
            $table->integer('03000069')->default(0);
            $table->integer('03000083')->default(0);
            $table->integer('03000137')->default(0);
            $table->integer('03000168')->default(0);
            $table->integer('03000076')->default(0);
            $table->integer('03000151')->default(0);
            $table->integer('03000175')->default(0);
            $table->integer('03000229')->default(0);
            $table->integer('03000182')->default(0);
            $table->integer('03000205')->default(0);
            $table->integer('03000281')->default(0);
            $table->integer('03000298')->default(0);
            $table->index('date');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales');
    }
}
