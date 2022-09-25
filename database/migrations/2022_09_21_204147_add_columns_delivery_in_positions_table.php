<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsDeliveryInPositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('positions', function (Blueprint $table) {
            $table->after('additional_cost_fact', function ($table) {
                $table->integer('delivery_cost_plan')->default(0);
                $table->integer('delivery_cost_fact')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('positions', function (Blueprint $table) {
            $table->dropColumn('delivery_cost_plan');
            $table->dropColumn('delivery_cost_fact');
        });
    }
}
