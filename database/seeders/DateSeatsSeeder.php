<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DateSeatsSeeder extends Seeder
{
    public function run()
    {
        $startDate = Carbon::now()->addDay();  // Start from tomorrow
        $seats = range(1, 50);  // Assuming 50 seats

        for ($i = 0; $i < 14; $i++) {  // 14 days (2 weeks)
            if ($startDate->isWeekend()) {
                $startDate->addDay();
                continue;  // Skip weekends
            }

            foreach ($seats as $seat) {
                DB::table('date_seats')->insert([
                    'date' => $startDate->format('Y-m-d'),
                    'seat_no' => $seat,
                    'is_booked' => false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            $startDate->addDay();
        }
    }
}
