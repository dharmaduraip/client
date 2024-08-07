<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDeliveryNameEnToDeliveryTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       

         Schema::connection('delivery')->table('delivery_types', function (Blueprint $table) {
            

            $table->string('delivery_name_fr')->nullable()->after('delivery_name');
            $table->string('delivery_name_en')->nullable()->after('delivery_name_fr');
            $table->string('delivery_name_ar')->nullable()->after('delivery_name_en');
              $table->string('delivery_name_es')->nullable()->after('delivery_name_ar');

            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('service')->table('service_subcategories', function (Blueprint $table) {
            //
        });
    }
}
