<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipsToRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->biginteger('company_id')->nullable()->change()->unsigned();
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
        Schema::table('roles', function (Blueprint $table) {
            $table->dropForeign('roles_company_id_foreign');
        });

        Schema::table('roles', function (Blueprint $table) {
            $table->dropIndex('roles_company_id_foreign');
        });

        Schema::table('roles', function (Blueprint $table) {
            $table->biginteger('company_id')->change();
        });
    }
}
