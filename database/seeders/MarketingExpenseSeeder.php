<?php

namespace Database\Seeders;

use App\Models\MarketingExpense;
use App\Models\TrafficSource;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class MarketingExpenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $trafficSources = TrafficSource::all();
        $users = User::all();

        if ($trafficSources->isEmpty() || $users->isEmpty()) {
            $this->command->warn('Please ensure TrafficSources and Users are seeded first.');

            return;
        }

        // Generate sample data for the last 30 days
        $startDate = Carbon::now()->subDays(30);
        $endDate = Carbon::now();

        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            // Random number of expenses per day (0-3 per traffic source)
            foreach ($trafficSources as $source) {
                $expenseCount = rand(0, 3);

                for ($i = 0; $i < $expenseCount; $i++) {
                    MarketingExpense::create([
                        'traffic_source_id' => $source->id,
                        'amount' => rand(50, 5000) + (rand(0, 99) / 100), // Random amount between $50.00 and $5000.99
                        'expense_date' => $date->format('Y-m-d'),
                        'notes' => $this->generateRandomNote(),
                        'created_by' => $users->random()->id,
                    ]);
                }
            }
        }
    }

    private function generateRandomNote(): ?string
    {
        $notes = [
            'Campaign optimization for better ROI',
            'New ad creative testing',
            'Increased budget for high-performing campaigns',
            'Holiday season promotion',
            'Brand awareness campaign',
            'Product launch marketing',
            'Retargeting campaign',
            'Lookalike audience testing',
            null, // Some expenses might not have notes
            null,
        ];

        return $notes[array_rand($notes)];
    }
}
