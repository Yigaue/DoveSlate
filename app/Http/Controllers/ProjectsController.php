<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    public function index()
    {

        $projects = auth()->user()->projects;
     //$projects = Project::all();

    return view('projects.index', compact('projects'));

    }

    public function store ()
    {

       $attributes = request()->validate(
        [
            'title' => 'required',
            'description' => 'required',
            'notes'=> 'min:3'
        ]);


        // We don't' need validate the authenticated user

    //    $attributes['owner_id'] = auth()->id();

       $project = auth()->user()->projects()->create($attributes);

       //  Project::create($attributes);
        // Project::create(request(['title', 'description']));


        return redirect ($project->path());

    }

    public function show(Project $project)
    {
        $message = ['abort' =>"Please this project belongs to someone, you're not allowed biko!"

                    ];

        // if(auth()->id() !== $project->owner_id)
        // just below is the alternative way of implementing the just above line

        $this->authorize('update', $project);

            //the auth check just below was removed when we switch to policy and
            // register it in the authserviceprovider

        // if(auth()->user()->isNot($project->owner))
        // {
        //     abort(403, $message['abort']);
        // }
        // $project = Project::findOrFail(request('project'));

        return view('projects.show', compact('project'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function update(Project $project)
    {

            $this->authorize('update' , $project);

            //the auth check just below was removed when we switch to policy and
            // register it in the authserviceprovider
        // if(auth()->user()->isNot($project->owner)){

        //     abort(403);
        // }

        $project->update(request(['notes']));

         return redirect($project->path());
    }
}
