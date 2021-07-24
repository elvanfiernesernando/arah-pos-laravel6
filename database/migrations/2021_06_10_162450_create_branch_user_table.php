<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branch_user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unique();
            $table->bigInteger('branch_id');
            $table->timestamps();
        });

        Schema::table('branch_user', function (Blueprint $table) {
            $table->biginteger('user_id')->change()->unsigned();
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->biginteger('branch_id')->change()->unsigned();
            $table->foreign('branch_id')->references('id')->on('branches')
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
        Schema::dropIfExists('branch_user');

        Schema::table('branch_user', function (Blueprint $table) {
            $table->dropForeign('branch_user_user_id_foreign');
        });

        Schema::table('branch_user', function (Blueprint $table) {
            $table->dropIndex('branch_user_user_id_foreign');
        });

        Schema::table('branch_user', function (Blueprint $table) {
            $table->biginteger('user_id')->change();
        });

        Schema::table('branch_user', function (Blueprint $table) {
            $table->dropForeign('branch_user_branch_id_foreign');
        });

        Schema::table('branch_user', function (Blueprint $table) {
            $table->dropIndex('branch_user_branch_id_foreign');
        });

        Schema::table('branch_user', function (Blueprint $table) {
            $table->biginteger('branch_id')->change();
        });
    }
}
