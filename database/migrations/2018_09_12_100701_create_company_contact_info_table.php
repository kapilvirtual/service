<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyContactInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_contact_info', function (Blueprint $table) {
            $table->increments('id');
			$table->unsignedInteger('company_id');
			$table->string('contact_name');
			$table->string('contact_phone_number');
			$table->string('contact_phone_ext');
			$table->string('contact_email');
			$table->string('contact_alt');
			$table->timestamps();
			$table->foreign('company_id')->references('id')->on('company_information')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company_contact_info');
    }
}
