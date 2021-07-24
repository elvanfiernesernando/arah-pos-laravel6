<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipsToBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('branches', function (Blueprint $table) {
            $table->biginteger('business_unit_id')->change()->unsigned();
            $table->foreign('business_unit_id')->references('id')->on('business_units')
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
        Schema::table('branches', function (Blueprint $table) {
            $table->dropForeign('branches_business_unit_id_foreign');
        });

        Schema::table('branches', function (Blueprint $table) {
            $table->dropIndex('branches_business_unit_id_foreign');
        });

        Schema::table('branches', function (Blueprint $table) {
            $table->biginteger('business_unit_id')->change();
        });
    }
}
