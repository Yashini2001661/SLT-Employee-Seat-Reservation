<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DateSeat extends Model
{
    use HasFactory;

    // Define the table if it's not named "date_seats" by Laravel convention
    protected $table = 'date_seats';

    // Define the fillable fields (columns) in your table
    protected $fillable = ['date', 'seat_no', 'is_booked'];

    // You can define any relationships here if needed
}


