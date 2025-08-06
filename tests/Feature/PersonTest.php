<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Person;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class PersonTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;

    public function testPerson()
    {
        $person = new Person();
        $person->first_name = 'Zika';
        $person->last_name = 'Harun';
        
        $person->save();

        $this->assertEquals('ZIKA Harun', $person->full_name);

        $person->full_name = 'Muhamad Alzika';

        $person->save();

        $this->assertEquals('MUHAMAD', $person->first_name);
        $this->assertEquals('Alzika', $person->last_name);
    }

    public function testCustomCasts()
    {
        $person = new Person();
        $person->first_name = 'Zika';
        $person->last_name = 'Harun';
        // If Person model expects AsAddress, use AsAddress instead of Address
        $person->address = new Address('Jalan menuju ketenangan', 'Jakarta', 'Indonesia', '15622');
        $person->save();

        $person = Person::find($person->id);
        $this->assertNotNull($person->address);
        $this->assertInstanceOf(Address::class, $person->address);
        $this->assertEquals('Jalan menuju ketenangan', $person->address->street);
    }
}
