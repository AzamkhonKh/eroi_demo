<?php

namespace Database\Seeders;

use App\Models\TrafficSource;
use Illuminate\Database\Seeder;

class TrafficSourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $trafficSources = [
            [
                'name' => 'Google Ads',
                'slug' => 'google-ads',
                'color' => '#4285F4',
                'description' => 'Google advertising platform for search and display ads',
                'is_active' => true,
            ],
            [
                'name' => 'Meta (Facebook/Instagram)',
                'slug' => 'meta',
                'color' => '#1877F2',
                'description' => 'Meta advertising platform for Facebook and Instagram ads',
                'is_active' => true,
            ],
            [
                'name' => 'TikTok Ads',
                'slug' => 'tiktok-ads',
                'color' => '#FF0050',
                'description' => 'TikTok advertising platform for short-form video ads',
                'is_active' => true,
            ],
            [
                'name' => 'LinkedIn Ads',
                'slug' => 'linkedin-ads',
                'color' => '#0A66C2',
                'description' => 'LinkedIn advertising platform for B2B marketing',
                'is_active' => true,
            ],
            [
                'name' => 'Twitter Ads',
                'slug' => 'twitter-ads',
                'color' => '#1DA1F2',
                'description' => 'Twitter advertising platform for promoted tweets and accounts',
                'is_active' => true,
            ],
            [
                'name' => 'YouTube Ads',
                'slug' => 'youtube-ads',
                'color' => '#FF0000',
                'description' => 'YouTube advertising platform for video marketing',
                'is_active' => true,
            ],
            [
                'name' => 'Pinterest Ads',
                'slug' => 'pinterest-ads',
                'color' => '#E60023',
                'description' => 'Pinterest advertising platform for visual discovery',
                'is_active' => true,
            ],
            [
                'name' => 'Snapchat Ads',
                'slug' => 'snapchat-ads',
                'color' => '#FFFC00',
                'description' => 'Snapchat advertising platform for AR and story ads',
                'is_active' => true,
            ],
        ];

        foreach ($trafficSources as $source) {
            TrafficSource::create($source);
        }
    }
}
