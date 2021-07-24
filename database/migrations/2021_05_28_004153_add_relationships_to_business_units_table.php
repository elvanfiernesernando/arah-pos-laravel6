<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipsToBusinessUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('business_units', function (Blueprint $table) {
            $table->biginteger('company_id')->change()->unsigned();
            $table->foreign('company_id')->references('id')->on('companies')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('business_units', function (Blueprint $table) {
            $table->dropForeign('business_units_company_id_foreign');
        });

        Schema::table('business_units', function (Blueprint $table) {
            $table->dropIndex('business_units_company_id_foreign');
        });

        Schema::table('business_units', function (Blueprint $table) {
            $table->biginteger('company_id')->change();
        });
    }
}
