<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDateSeatsTable extends Migration
{
    public function up()
    {
        Schema::create('date_seats', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->integer('seat_no');
            $table->boolean('is_booked')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('date_seats');
    }
}
