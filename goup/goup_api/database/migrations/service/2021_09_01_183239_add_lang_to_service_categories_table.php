<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLangToServiceCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('service')->table('service_categories', function (Blueprint $table) {
             $table->string('service_category_name_en')->nullable()->after('service_category_name');
            $table->string('service_category_name_es')->nullable()->after('service_category_name_en');
            $table->string('service_category_name_fr')->nullable()->after('service_category_name_en');
            $table->string('service_category_name_ar')->nullable()->after('service_category_name_fr');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('service_categories', function (Blueprint $table) {
            //
        });
    }
}
