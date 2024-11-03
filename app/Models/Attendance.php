<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $table = 'attendance'; // Table name

    // Define the relationship with BookingDetail
    public function bookingDetails()
    {
        return $this->belongsTo(BookingDetail::class, 'emp_id', 'emp_id'); // Match emp_id in both tables
    }

    // Allow mass assignment for these fields
    protected $fillable = [
        'emp_id', 'date', 'attendance_status', 'seat_no', // seat_no is part of attendance
    ];
}

