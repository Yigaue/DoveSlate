<?php

namespace Tests\Feature;

use App\Project;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\ProjectFactory;
use Facades\Tests\Setup\ProjectFactory as SetupProjectFactory;

//use Tests\Setup\ProjectFactory;


class ProjectTasksTest extends TestCase
{
   use RefreshDatabase;

   /** @test */

   public function guests_can_not_add_tasks_to_project()
   {
    $project = factory(Project::class)->create();

    $this->post($project->path().'/tasks')->assertRedirect('login');

   }

   /** @test */

   public function only_the_owner_of_a_project_may_add_task()
   {

        $this->signIn();

       $project = factory(Project::class)->create();

       $this->post($project->path() . '/tasks', ['body' => 'Test task'])

       ->assertStatus(403);
       $this->assertDatabaseMissing('tasks', ['body'=> 'Test task']);
   }

   /** @test */

   public function only_the_owner_of_a_project_may_update_task()
   {

        $this->SignIn();

        $project = SetupProjectFactory::withTasks()->create();

    //    $project = factory(Project::class)->create();

    //    $task = $project->addTask('test task');

       $this->patch($project->tasks[0]->path(), [

        'body' => 'changed',
       ])->assertStatus(403);

       $this->assertDatabaseMissing('tasks', ['body' => 'changed']);
   }

   /** @test */
   public function a_project_can_have_tasks()
   {


        // $this->SignIn(); // from the alias we created in TestCase Class

         $project = ProjectFactory::create();

        //  $project = auth()->user()->projects()->create(

        //     factory(Project::class)->raw()
        //  );

         // this was the initial code, alternative just above
        // $project = factory(Project::class)->create(['owner_id' => auth()->id()]);


         $this->actingAs($project->owner)->post($project->path(). '/tasks', ['body' => 'Task test']);

         $this->get($project->path())->assertSee('Task test');
   }

   /** @test */

   public function a_task_can_be_updated()
   {

      //$project =  app(ProjectFactory::class)
     // ->ownedBy($this->SignIn()) // we use ActingAs when posting the project as below: ...$this->actingAs($project->owner)->patch...
    //   ->withTasks()
    //   ->create();

       $project =  ProjectFactory::withTasks()->create();
       // we added 'Facades' to the path of the tests\Setup\ProjectFactory;
       // like so: Facades\tests\Setup\ProjectFactory; so we can use it like its a facade





        /*
        |----------------------------------------------------
        | This whole block of code just below was refactored into
        | tests/SetUp/ProjectFactor
        |----------------------------------------------------

        $this->signIn();

        $project = auth()->user()->projects()->create(

        factory(Project::class)->raw()
        );
        $task = $project->addTask('test task');

     */

        // $this->patch($project->path(). '/tasks/'. $project->tasks[0]->id, [
        $this->actingAs($project->owner)->patch($project->tasks->first()->path(), [
            'body' => 'changed',
            'completed' => true,
        ]);

        $this->assertDatabaseHas( 'tasks', [
            'body' => 'changed',
            'completed' => true,
        ]);
   }

   /** @test */

   public function a_task_requires_a_body()

   {

    //$this->signIn();

    $project = ProjectFactory::create();

    //  $project = auth()->user()->projects()->create(
    // factory(Project::class)->raw()
    // );

    $attributes = factory('App\Task')->raw(['body' => '']);

    $this->actingAs($project->owner)->post($project->path() .'/tasks', $attributes)->assertSessionHasErrors('body');
   }
}
