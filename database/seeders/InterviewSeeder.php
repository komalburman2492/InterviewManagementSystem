<?php

namespace Database\Seeders;

use App\Constants\InterviewRecommendationConstants;
use App\Constants\InterviewTypeConstants;
use App\Models\Interview;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class InterviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Interview::create([
            'interviewer_id' => User::where('role', 2)->inRandomOrder()->value('id'),
            'candidate_id' => User::where('role', 3)->inRandomOrder()->value('id'),
            'scheduled_at' => now()->addDays(1),
            'interview_type' => InterviewTypeConstants::HR,
            'feedback_strengths' => '',
            'feedback_weaknesses' => 'Needs improvement in coding',
            'feedback_recommendation' =>  InterviewRecommendationConstants::NEW,
        ]);

        Interview::create([
            'interviewer_id' => User::where('role', 2)->inRandomOrder()->value('id'),
            'candidate_id' => User::where('role', 3)->inRandomOrder()->value('id'),
            'scheduled_at' => now()->addDays(1),
            'interview_type' => InterviewTypeConstants::TECHNICAL,
            'feedback_strengths' => 'Good Communication skill',
            'feedback_weaknesses' => 'Needs improvement in coding',
            'feedback_recommendation' =>  InterviewRecommendationConstants::HIRED,
        ]);
    }
}
