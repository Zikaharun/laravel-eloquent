<?php

namespace Database\Seeders;

use App\Models\Journal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JournalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $journals = new Journal();
        $journals->id = '1'; // UUID can be generated automatically if you set it in the model
        $journals->title = 'My First Journal Entry';
        $journals->content = 'This is the content of my first journal entry.';
        $journals->save();
    }
}
