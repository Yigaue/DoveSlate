<?php

namespace Tests\Feature;

use App\Project;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

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

       $project = factory(Project::class)->create();

       $task = $project->addTask('test task');

       $this->patch($task->path(), [

        'body' => 'changed',
       ])->assertStatus(403);

       $this->assertDatabaseMissing('tasks', ['body' => 'changed']);
   }

   /** @test */
   public function a_project_can_have_tasks()
   {

        // from the alias we created in TestCase Class
         $this->SignIn();

         $project = auth()->user()->projects()->create(

            factory(Project::class)->raw()
         );

         // this was the initial code, alternative just above
        // $project = factory(Project::class)->create(['owner_id' => auth()->id()]);


         $this->post($project->path(). '/tasks', ['body' => 'Task test']);

         $this->get($project->path())->assertSee('Task test');
   }

   /** @test */

   public function a_task_can_be_updated()
   {
       $this->withoutExceptionHandling();

       $this->signIn();

       $project = auth()->user()->projects()->create(

        factory(Project::class)->raw()
    );
        $task = $project->addTask('test task');

        $this->patch($task->path(), [
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

    $this->signIn();

     $project = auth()->user()->projects()->create(
    factory(Project::class)->raw()
    );

    $attributes = factory('App\Task')->raw(['body' => '']);

    $this->post($project->path() .'/tasks', $attributes)->assertSessionHasErrors('body');
   }
}
