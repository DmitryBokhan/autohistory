<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsInAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accounts', function (Blueprint $table) {
            $table->after('sum', function ($table) {
                $table->integer('position_id')->nullable();
                $table->integer('operation_id');
                $table->integer('invest_scheme_id')->nullable(); // схема расчета инвестиционного дохода
                $table->float('invest_percent')->nullable(); // % от продажи/прибыли
                $table->float('invest_fixed')->nullable(); //фиксированная премия после продажи позиции
                $table->integer('pay_purpose_id')->nullable(); // цель инвестиции (покупка/длставка/подготовка)
                $table->text('comment')->nullable();
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
        Schema::table('accounts', function (Blueprint $table) {
            $table->dropColumn('position_id');
            $table->dropColumn('operation_id');
            $table->dropColumn('invest_scheme_id');
            $table->dropColumn('invest_percent');
            $table->dropColumn('invest_fixed');
            $table->dropColumn('pay_purpose_id');
            $table->dropColumn('comment');
        });
    }
}
