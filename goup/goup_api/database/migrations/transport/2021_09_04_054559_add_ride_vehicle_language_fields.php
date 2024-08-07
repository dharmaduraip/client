<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRideVehicleLanguageFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      
        Schema::connection('transport')->table('ride_delivery_vehicles', function (Blueprint $table) {

           
            $table->string('vehicle_name_fr')->nullable()->after('vehicle_name');
            $table->string('vehicle_name_en')->nullable()->after('vehicle_name');
            $table->string('vehicle_name_ar')->nullable()->after('vehicle_name_fr');
            $table->string('vehicle_name_es')->nullable()->after('vehicle_name_fr');
            

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::connection('transport')->table('ride_delivery_vehicles', function (Blueprint $table) {

           
            $table->string('vehicle_name_ku')->nullable()->after('vehicle_name');
            $table->string('vehicle_name_en')->nullable()->after('vehicle_name');
            $table->string('vehicle_name_ar')->nullable()->after('vehicle_name_ku');
        
        });
    }
}
