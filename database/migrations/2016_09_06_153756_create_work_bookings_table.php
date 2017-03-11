<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_bookings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ten_congviec');
            $table->text('description');
            $table->float('luong');
            $table->float('thuong');
            $table->string('time_start', 15);
            $table->string('time_end', 15);
            $table->text('address');
            $table->string('lat', 15);
            $table->string('long', 15);
            $table->string('type', 15);
            $table->tinyInteger('status');
            $table->text('note');
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
        Schema::drop('work_books');
    }
}
