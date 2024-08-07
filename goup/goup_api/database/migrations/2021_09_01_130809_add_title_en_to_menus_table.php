<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTitleEnToMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('common')->table('menus', function (Blueprint $table) {
            $table->string('title_en')->nullable()->after('title');
            $table->string('title_fr')->nullable()->after('title_en');
            $table->string('title_ar')->nullable()->after('title_fr');
            $table->string('title_es')->nullable()->after('title_ar');
        });


        Schema::connection('common')->table('admin_services', function (Blueprint $table) {
            $table->string('display_name_en')->nullable()->after('display_name');
            $table->string('display_name_fr')->nullable()->after('display_name_en');
            $table->string('display_name_ar')->nullable()->after('display_name_fr');
            $table->string('display_name_es')->nullable()->after('display_name_ar');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('menus', function (Blueprint $table) {
            //
        });
    }
}
