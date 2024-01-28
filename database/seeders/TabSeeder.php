<?php

namespace Database\Seeders;

use App\Models\Chord;
use App\Models\Tab;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TabSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $chords = Chord::query()->get();
        
        Tab::factory(100)->create()->each(function (Tab $tab) use ($chords) {
            $tab->chords()->saveMany($chords->random($tab->no_of_chords));
        });
    }
}
