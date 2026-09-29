<?php

namespace Database\Seeders;

use App\Models\Activity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        Activity::create(
            [
                'activity_type' => 'palestra',
                'start_time' => '19:00',
                'end_time' => '20:10',
                'description' => "Privacidade e Segurança de Dados (Palestra de 2:00h)",
                'date' => '2026/09/29'
            ]
        );
        Activity::create(
            [
                'activity_type' => 'oficina',
                'start_time' => '20:20',
                'end_time' => '22:00',
                'description' => "Cibersegurança (Oficina de 4:00h)",
                'date' => '2026/09/29'
            ]
        );
    }
}
