<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingDetail extends Model
{
    use HasFactory;

    protected $table = 'booking_details'; // Table name

    // Define the relationship with Attendance
    public function attendance()
    {
        return $this->hasOne(Attendance::class, 'emp_id', 'emp_id'); // Adjust if necessary
    }

    // Allow mass assignment for these fields
    protected $fillable = [
        'emp_id', 'employee_name', 'phone_number', 'email', 'date', 'seat_no',
    ];
}
