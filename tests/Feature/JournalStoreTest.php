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
        $result = $journal->update();

        $this->assertTrue($result);

        // Verify that the journal was updated
        $updatedJournal = Journal::find('1');
        $this->assertEquals('Updated Journal Entry', $updatedJournal->title);
        $this->assertEquals('This is the updated content of my first journal entry.', $updatedJournal->content);
    }

    public function testSelect()
    {
        for ($i = 0; $i < 5; $i++) {
            $journal = new Journal();
            $journal->id = "$i"; // Generate a UUID for the primary key
            $journal->title = "Journal Entry $i";
            $journal->save();
        }

        $journal = Journal::query()->whereNull('content')->get();
        $this->assertEquals(5, $journal->count());
        $journal->each(function ($journal) {
            $this->assertNull($journal->content);
        });
    }

    public function testUpdateSelectResult()
    {
        for ($i = 0; $i < 5; $i++) {
            $journal = new Journal();
            $journal->id = "$i"; // Generate a UUID for the primary key
            $journal->title = "Journal Entry $i";
            $journal->save();
        }
        $journal = Journal::query()->whereNull('content')->get();
        $this->assertEquals(5, $journal->count());
        $journal->each(function ($journal) {
            $journal->content = 'updated content';
            $result = $journal->update();
            $this->assertTrue($result);
        });
    }

    public function testUpdatedMany()
    {
        $journals = [];
        for ($i = 1; $i <= 10; $i++) {
            $journals[] = [
                'id' => "$i",
                 'title' => 'Journal Entry ' . $i,
            ];
    }
        $result = Journal::query()->insert($journals);
        $this->assertTrue($result);

        Journal::query()->whereNull('content')->update(['content' => 'updated content']);
        $total = Journal::query()->where('content', 'updated content')->count();
        $this->assertEquals(10, $total);
}

    public function testDelete()
    {
        $this->seed(JournalSeeder::class);
        $journal = Journal::find('1');
        $result = $journal->delete();

        $this->assertTrue($result);

        // Verify that the journal was deleted
        $deletedJournal = Journal::find('1');
        $total = Journal::query()->count();
        $this->assertEquals(0, $total);
        $this->assertNull($deletedJournal);
    }

    public function testDeleteMany()
    {
        $journals = [];
        for ($i = 0; $i < 10; $i++) {
            $journals[] = [
                'id' => "$i",
                'title' => "Journal Entry $i"
            ];
        }
        $result = Journal::insert($journals);
        $this->assertTrue($result);

        $total = Journal::count();
        $this->assertEquals(10, $total);

        Journal::query()->whereNull('content')->delete();

        $total = Journal::query()->count();
        $this->assertEquals(0, $total);
    }


}
