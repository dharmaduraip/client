<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddServiceSubcategoriesLanguageFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::connection('service')->table('service_subcategories', function (Blueprint $table) {
            

            $table->string('service_subcategory_name_fr')->nullable()->after('service_subcategory_name');
            $table->string('service_subcategory_name_en')->nullable()->after('service_subcategory_name');
            $table->string('service_subcategory_name_ar')->nullable()->after('service_subcategory_name_fr');
              $table->string('service_subcategory_name_es')->nullable()->after('service_subcategory_name');

            
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
            

            $table->string('service_subcategory_name_ku')->nullable()->after('service_subcategory_name');
            $table->string('service_subcategory_name_en')->nullable()->after('service_subcategory_name');
            $table->string('service_subcategory_name_ar')->nullable()->after('service_subcategory_name_ku');

            
        });
    }
}
