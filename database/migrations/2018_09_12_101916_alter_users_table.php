<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name')->after('name');
			$table->string('middle_name')->after('first_name');
			$table->string('last_name')->after('middle_name');
			$table->smallInteger('verified')->default('0')->after('remember_token');
			$table->smallInteger('invited')->default('0')->after('verified');
			$table->enum('user_status', ['inactive','active'])->default('inactive')->after('invited');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function($table) {
			$table->dropColumn('first_name');
			$table->dropColumn('middle_name');
			$table->dropColumn('last_name');
			$table->dropColumn('verified');
			$table->dropColumn('invited');
			$table->dropColumn('user_status');
		});
    }
}
