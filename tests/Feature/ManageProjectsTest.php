<?php

namespace Tests\Feature;

use App\Project;
use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;



class ManageProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;


    /** @test */

    public function guest_cannot_manage_projects()
    //This test just above and below was rename after merging of the three guest related test into one
    //public function guest_cannot_create_projects()

    {
        // this line just below was uncommented to and cast to array because
        // the diff between create() and raw() is raw() returns array while create() returns object

        // $attributes = factory('App\Project')->raw();

         $project = factory('App\Project')->create();

        $this->get('/projects/create')->assertRedirect('login');

        $this->get('/projects')->assertRedirect('login');

        $this->get($project->path())->assertRedirect('login');

        $this->post('/projects', $project->toArray())->assertRedirect('login');

    }

    // /** @test */
    // public function guest_cannot_view_projects()
    // {
    //     // the line just below was moved/merge to guests_cannot_manage_project

    //     // $this->get('/projects')->assertRedirect('login');
    // }

    // /** @test */

    // public function guest_cannot_view_single_project()

    // {
    //     // the line just below was moved/merged to guests_cannot_manage_project
    //     // $project = factory('App\Project')->create();


    //     // the line just below was moved/merged to guests_cannot_manage_project

    //     // $this->get($project->path())->assertRedirect('login');
    // }

    /** @test */

    public function a_user_can_create_a_project()

    {

        $this->withoutExceptionHandling();

        $this->actingAs(factory('App\User')->create());

        $this->get('/projects/create')->assertStatus(200);

        $attributes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->sentence,
            'notes' => 'General notes here',
        ];

        $response = $this->post('/projects', $attributes);

        $project = Project::where($attributes)->first();

        $response->assertRedirect($project->path());

        $this->assertDatabaseHas('projects', $attributes);

        $this->get($project->path())

        ->assertSee($attributes['title'])
        ->assertSee($attributes['description'])
        ->assertSee($attributes['notes']);


    }

    /** @test */

    public function a_user_can_update_a_project()
    {
       // $this->SignIn();

        $project = ProjectFactory::create();

        // the code lline just below was refactored into
        // tests/SetUp/ProjectFactor

        // $project = factory(Project::class)->create(['owner_id' => auth()->id()]);

        $this->actingAs($project->owner)

        ->patch($project->path(), $attributes = [ 'notes' => 'changed'])

        ->assertRedirect($project->path());

        $this->assertDatabaseHas('projects' , $attributes);
    }

    /** @test */

    public function a_user_can_view_their_project()
    {

        // 'be' is same as actingAs: the signin user
       // $this->be(factory('App\User')->create());

        $project = ProjectFactory::create();

        $this->actingAs($project->owner)->get($project->path())
        // $this->get('/projects/'.$project->id)
        ->assertSee($project->title)
        ->assertSee($project->description);
    }

    /** @test */

    public function an_authenticated_user_cannot_view_the_project_of_others()
    {
        //$this->withoutExceptionHandling();

        $this->be(factory('App\User')->create());

        $project = factory('App\Project')->create();

        $this->get($project->path())->assertStatus(403);
    }

    /** @test */

    public function an_authenticated_user_cannot_update_the_project_of_others()
    {
        //$this->withoutExceptionHandling();

        $this->SignIn();

        $project = factory('App\Project')->create();

        $this->patch($project->path())->assertStatus(403);
    }


    /** @test */

    public function a_project_requires_a_title()

    {
        // the raw(['title=>'']) attached to the end of the factory overides the title attribute
        // in the factory('App\Project);

        $this->actingAs(factory('App\User')->create());

        $attributes = factory('App\Project')->raw(['title'=> '']);

        $this->post('/projects', $attributes)->assertSessionHasErrors('title');
    }

    /** @test */

    public function a_project_requires_a_description()

    {
        //Sign someone in
        $this->actingAs(factory('App\User')->create());

        $attributes = factory(Project::class)->raw(['description'=> '']);

        $this->post('/projects', $attributes)->assertSessionHasErrors('description');
    }

}
