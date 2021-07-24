<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('status')->default(true)->after('password');
            $table->boolean('is_profile_completed')->default(false)->after('status');
            $table->string('user_photo')->nullable()->after('is_profile_completed');
            $table->string('idcard_photo')->nullable()->after('user_photo');
            $table->string('idcard_no')->nullable()->after('idcard_photo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
