<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsAuthorRecipientInAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accounts', function (Blueprint $table) {
            $table->after('comment', function ($table) {
                $table->unsignedInteger('operation_author_id')->nullable(); //автор операции
                $table->unsignedInteger('recipient_id')->nullable(); // получатель перевода
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
            $table->dropColumn('operation_author_id');
            $table->dropColumn('recipient_id');
        });
    }
}
