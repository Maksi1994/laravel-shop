<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParamsProductValuePivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('param_product_value', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('param_id')->unsigned();
            $table->integer('value_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->foreign('param_id')->references('id')->on('params')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('value_id')->references('id')->on('values')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('param_product_value');
    }
}
