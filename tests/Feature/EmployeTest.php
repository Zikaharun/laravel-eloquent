<?php

namespace Tests\Feature;

use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmployeTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;

    public function testFactory()
    {
        $employee = Employee::factory()->programmer()->make();
        $employee->id = '1';
        $employee->name = 'Employee 1';
        $employee->save();

        $this->assertNotNull(Employee::where('id', '1')->first());
    }


}
