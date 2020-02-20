<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
{

    use RefreshDatabase;

    /** @test */

    public function it_has_a_path()
    {
        $project = factory('App\Project')->create();

        $this->assertEquals('/projects/'.$project->id, $project->path());
    }

    /** @test */
    public function it_belongs_to_an_owner()
    {
        $project =  factory('App\Project')->create();

        $this->assertInstanceOf('App\User', $project->owner);
    }

    /** @test */

    public function it_can_add_a_task()
    {
        $project = factory('App\Project')->create();

        $project->addTask('Test task');

        $this->assertCount(1, $project->tasks);
    }

      /** @test */
    // public function it_can_add_a_taska()
    // {
    //     $project = factory('App\Project')->create();

    //     $this->assertEquals("Obi Mike", $project->add("Obi", "Mike"));
    // }

    //    /** @test */
    //    public function it_can_add_a_task_multiply()
    //    {
    //        $project = factory('App\Project')->create();

    //        $this->assertEquals(6, $project->multiply(2, 3));

    //    }

    //    /** @test */
    //    public function it_can_add_a_task_multiply_invalid()
    //    {
    //        $project = factory('App\Project')->create();

    //        $this->assertEquals("we need ints", $project->multiply("2", "3"));

    //    }


}
