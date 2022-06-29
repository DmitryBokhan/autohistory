<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('position_status_id');
            $table->string('car_id');
            $table->unsignedInteger('user_id');
            $table->string('year');
            $table->string('car_number');
            $table->date('date_purchase');
            $table->date('date_sale'); //дата покупки позиции
            $table->integer('price_pruchase'); //стоимость покупки
            $table->unsignedInteger('city_id'); //город покупки автомобиля
            $table->integer('delivery_cost'); //затраты на доставку
            $table->date('start_preparation'); //дата начала подготовки
            $table->integer('plan_preparation'); //планироемое количество дней на подготовку автомобиля
            $table->date('end_preparation'); //дата окончания подготовки
            $table->integer('additional_cost_plan'); //планируемая сумма продажи позиции
            $table->integer('additional_cost_fact'); //фактическая сумма продажи позиции
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
        Schema::dropIfExists('positions');
    }
}
