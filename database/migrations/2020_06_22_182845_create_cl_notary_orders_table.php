<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClNotaryOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cl_notary_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('region_id');
            $table->integer('office_id');
            $table->integer('user_id');
            $table->integer('action_id');
            $table->integer('sub_action_1_id')->default(null);
            $table->integer('sub_action_2_id')->default(null);
            $table->integer('service_id');
            $table->integer('code');
            $table->integer('count');
            $table->integer('price');
            $table->date('start_date');
            $table->date('finish_date');
            $table->boolean('type');
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
        Schema::dropIfExists('cl_notary_orders');
    }
}
