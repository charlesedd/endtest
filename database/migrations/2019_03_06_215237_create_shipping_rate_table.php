<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShippingRateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipping_rate', function (Blueprint $table) {
            $table->string('name', 100);
            $table->string('country_code', 2);
            $table->decimal('from_value', 10, 2);
            $table->decimal('to_value', 10, 2);
            $table->integer('weight');
            $table->decimal('shipping_fee', 10, 2);
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
        Schema::dropIfExists('shipping_rate');
    }
}
