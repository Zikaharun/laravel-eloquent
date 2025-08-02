<?php

namespace Tests\Feature;

use App\Models\Journal;
use Database\Seeders\JournalSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class JournalStoreTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    use RefreshDatabase;
    
    public function testInsert()
    {
        $journal = new Journal();
        $journal->title = 'My First Journal Entry';
        $journal->content = 'This is the content of my first journal entry.';
        $result = $journal->save();

        $this->assertTrue($result);
    }

    public function testInsertManyCategories()
    {
        $journals = [];
        for ($i = 1; $i <= 10; $i++) {
            $journals[] = [
                'id' => (string) Str::uuid(), // Generate a UUID for the primary key
                'title' => 'Journal Entry ' . $i,
                'content' => 'This is the content of journal entry ' . $i,
            ];
        }

        $result = Journal::insert($journals);
        $this->assertTrue($result);


        // Verify that the journals were inserted
        $total = Journal::count();
        $this->assertEquals(10, $total);
        
    }

    public function testFind()
    {
        $this->seed(JournalSeeder::class);
        $journal = Journal::find('1');
        $this->assertNotNull($journal);
        $this->assertEquals('My First Journal Entry', $journal->title);
        $this->assertEquals('This is the content of my first journal entry.', $journal->content);

    }

    public function testUpdate()
    {
        $this->seed(JournalSeeder::class);
        $journal = Journal::find('1');
        $journal->title = 'Updated Journal Entry';
        $journal->content = 'This is the updated content of my first journal entry.';
        $result = $journal->save();

        $this->assertTrue($result);

        // Verify that the journal was updated
        $updatedJournal = Journal::find('1');
        $this->assertEquals('Updated Journal Entry', $updatedJournal->title);
        $this->assertEquals('This is the updated content of my first journal entry.', $updatedJournal->content);
    }


}
