<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
			$table->string('service_title')->nullable(false);
            $table->longText('service_description')->nullable(false);
			$table->longText('service_comments')->nullable(false);
			$table->enum('data_classification', ['public','confidential','restricted','highlyrestricted'])->nullable(false);
			$table->enum('service_status', ['solidgreen','flashinggreen','flashingyellow','flashingred'])->default('solidgreen');
			$table->enum('check_status', ['0','1'])->default('1');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service');
    }
}
