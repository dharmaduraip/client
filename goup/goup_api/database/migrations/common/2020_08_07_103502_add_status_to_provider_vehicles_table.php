<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusToProviderVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('provider_vehicles', function (Blueprint $table) {
            $table->enum('status', ['ASSESSING', 'ACTIVE','INACTIVE'])->default('ACTIVE')->after('child_seat');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('provider_vehicles', function (Blueprint $table) {
            //
        });
    }
}
