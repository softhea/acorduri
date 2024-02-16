<?php

namespace Database\Seeders;

use App\Models\Chord;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $chords = [
            'A', 'Am', 'B7', 'C', 'D', 'E', 'Em', 'F', 'G',
        ];

        foreach ($chords as $chord) {
            Chord::factory()->create([
                'chord' => $chord,
            ]);
        }
    }
}
