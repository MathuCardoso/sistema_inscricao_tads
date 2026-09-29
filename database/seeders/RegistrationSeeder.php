<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Participant;
use App\Models\Registration;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegistrationSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $participants = Participant::all();
        $activities = Activity::all();
        foreach ($participants as $participant) {
            foreach ($activities as $activity) {
                Registration::create(['participant_id' => $participant->id, 'activity_id' => $activity->id, 'presence' => false,]);
            }
        }
    }
}
