<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RemoveOldDateSeats extends Command
{
    protected $signature = 'seats:remove-old';
    protected $description = 'Remove seat records for today';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
{
    // Logic to rotate seats (delete past records and add future ones)
    $today = Carbon::today();
    DB::table('date_seats')->where('date', '<', $today)->delete();

    // Assuming you want to add records for future dates
    $lastDay = $today->addDays(9);
    for ($seat = 1; $seat <= 100; $seat++) {
        DB::table('date_seats')->insert([
            'date' => $lastDay,
            'seat_no' => $seat,
            'is_booked' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    $this->info('Seat rotation completed successfully.');
}




}
