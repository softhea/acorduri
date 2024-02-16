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
            $chordsForThisTab = $chords->random($tab->getNoOfChords());
            
            $text = '';
            /** @var Chord $chord */
            foreach ($chordsForThisTab as $chord) {
                $text .= '$' . $chord->getChord() . "\r\n";
                $text .= fake()->text() . "\r\n";
            }
            $text .= fake()->text();

            $tab->update([Tab::COLUMN_TEXT => $text]);

            $tab->chords()->saveMany($chordsForThisTab);
        });
    }
}
