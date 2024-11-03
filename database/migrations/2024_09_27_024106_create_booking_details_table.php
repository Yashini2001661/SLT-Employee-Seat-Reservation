<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('booking_details', function (Blueprint $table) {
        $table->id();
        $table->string('emp_id', 50);
        $table->date('date');
        $table->integer('seat_no');
        $table->string('employee_name', 100);
        $table->string('phone_number', 15);
        $table->string('email', 100);
        $table->timestamps(); // This will automatically add `created_at` and `updated_at` columns
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_details');
    }
};
