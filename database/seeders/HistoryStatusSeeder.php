<?php

namespace Database\Seeders;

use App\Models\HistoryStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class HistoryStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now('utc')->toDateTimeString();
        HistoryStatus::insert([
            [
                'name' => 'Healthy',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Unhealthy',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
