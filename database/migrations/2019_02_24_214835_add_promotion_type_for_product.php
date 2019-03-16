<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPromotionTypeForProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_promotion', function (Blueprint $table) {
            $table->integer('promotion_type_id')->unsigned()->nullable();
            $table->foreign('promotion_type_id')->references('id')->on('promotions_types')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_promotion', function (Blueprint $table) {
            $table->dropForeign('product_promotion_promotion_type_id_foreign');
            $table->dropColumn('promotion_type_id');
        });
    }
}
