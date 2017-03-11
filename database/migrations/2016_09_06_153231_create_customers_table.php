<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('type_customer')->default(1);
            $table->string('manv', 15);
            $table->string('fullname');
            $table->string('avatar');
            $table->string('anhsv_truoc');
            $table->string('anhsv_sau');
            $table->string('anhcmtnd_truoc');
            $table->string('anhcmtnd_sau');
            $table->float('vi_tien');
            $table->float('vi_taikhoan');
            $table->string('phone_number', 15);
            $table->string('lat', 15);
            $table->string('long', 15);
            $table->string('email');
            $table->string('password');
            $table->string('forgot_password');
            $table->date('birthday');
            $table->string('quequan');
            $table->string('school');
            $table->tinyInteger('has_experience')->default(0);
            $table->tinyInteger('viec_1_lan')->default(0);
            $table->tinyInteger('viec_thuongxuyen')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->float('year_exp');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('customers');
    }
}
