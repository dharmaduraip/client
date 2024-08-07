<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusToProviderAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('provider_addresses', function (Blueprint $table) {
            $table->string('title')->nullable()->after('county');
            $table->text('map_address')->nullable()->after('longitude');
            $table->enum('status', ['ASSESSING', 'ACTIVE'])->default('ASSESSING')->after('map_address');
            $table->string('address_proof')->nullable()->after('status');
            $table->string('proof_name')->nullable()->after('address_proof');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('provider_addresses', function (Blueprint $table) {
            //
        });
    }
}
