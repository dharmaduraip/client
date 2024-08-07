<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMinsFareColumnToDeliveryPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('delivery')->table('delivery_payments', function (Blueprint $table) {
            $table->float('weight_fare', 10, 2)->default(0)->after('distance');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('delivery')->table('delivery_payments', function (Blueprint $table) {
            $table->dropColumn('weight_fare');
        });
    }
}
