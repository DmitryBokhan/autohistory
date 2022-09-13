<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePositionsTable2 extends Migration
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
            $table->string('year');
            $table->string('gos_number');
            $table->date('purchase_date');//дата покупки позиции
            $table->date('sale_date')->nullable(); //дата продажи позиции
            $table->integer('purchase_cost'); //стоимость покупки
            $table->unsignedInteger('city_id'); //город покупки автомобиля
            $table->date('preparation_start'); //дата начала подготовки
            $table->integer('preparation_plan'); //планироемое количество дней на подготовку автомобиля
            $table->date('preparation_end')->nullable(); //дата окончания подготовки
            $table->integer('additional_cost_plan'); //планируемая сумма продажи позиции
            $table->integer('additional_cost_fact')->nullable(); //фактическая сумма продажи позиции
            $table->text('comment')->nullable();
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
