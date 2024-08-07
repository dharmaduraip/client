<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRideNameKrToRideTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('transport')->table('ride_types', function (Blueprint $table) {
            $table->string('ride_name_fr')->nullable()->after('ride_name');
            $table->string('ride_name_ar')->nullable()->after('ride_name_fr');
            $table->string('ride_name_es')->nullable()->after('ride_name_ar');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ride_types', function (Blueprint $table) {
            //
        });
    }
}
