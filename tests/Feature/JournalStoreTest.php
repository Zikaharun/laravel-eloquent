<?php

namespace Tests\Feature;

use App\Models\Journal;
use App\Models\Scopes\IsActiveScope;
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
                'is_active' => true, // Set the is_active status
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
            $journal->is_active = true;
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
            $journal->is_active = true; // Set the is_active status
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
                 'is_active' => true, // Set the is_active status
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
                'title' => "Journal Entry $i",
                'is_active' => true, // Set the is_active status
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

    public function testDefaultAttributeValues()
    {
        $journal = new Journal();
        $journal->id = (string) Str::uuid(); // Generate a UUID for the primary key
        $journal->save();

        $this->assertEquals('Sample Title', $journal->title);
        
    }

    public function testCreateMethod()
    {
        $request = [
            'title' => 'Test Journal Entry',
            'content' => 'This is a test journal entry created using the create method.',

            'is_active' => true, // Set the is_active status
        ];

        $journal = Journal::create($request);

        $this->assertNotNull($journal);
    }

    public function testUpdatedMethod()
    {
        $this->seed(JournalSeeder::class);

        $request = [
            'title' => 'Updated Journal Entry',
            'content' => 'This is the updated content of my first journal entry.',
            'is_active' => true, // Ensure is_active is set to true
        ];


        $journal = Journal::find('1');
        $journal->fill($request);
        $result = $journal->save();

        $this->assertNotNull($journal->id);
    }

    public function testSOftDeletes()
    {
        $this->seed(JournalSeeder::class);

        $journal = Journal::where('id', '1')->first();
        $journal->delete();

        $journal = Journal::where('id', '1')->first();
        $this->assertNull($journal);

        $journal = Journal::withTrashed()->where('id', '1')->first();
        $this->assertNotNull($journal);

        
       
    }

    public function testGlobalScope()
    {
        $journals = new Journal();
        $journals->id = '10';
        $journals->title = 'Global Scope Journal';
        $journals->is_active = false; // Set is_active to true

        $journals->save();

        $journals = Journal::find('10');
        $this->assertNull($journals); // Should be null due to global scope filtering

        $journals = Journal::withoutGlobalScope(IsActiveScope::class)->find('10');
        $this->assertNotNull($journals); // Should not be null when global scope is removed

    }

    public function testLocalScope()
    {
        $journals = new Journal();
        $journals->id = '11';
        $journals->title = 'Local Scope Journal';
        $journals->is_active = true; // Set is_active to false
        $journals->local_is_active = true; // Set is_active to true
    
        $journals->save();

        $total = Journal::active()->count();
        $this->assertEquals(1, $total); // Should return 1 active

        $total = Journal::nonActive()->count();
        $this->assertEquals(0, $total); // Should return 0 non-active
    }


}
