<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    public function index()
    {
     $projects = Project::all();

    return view('projects.index', compact('projects'));

    }

    public function store ()
    {

       $attributes = request()->validate(
        [
            'title' => 'required',
            'description' => 'required',
        ]);

        // We don't' need validate the authenticated user

    //    $attributes['owner_id'] = auth()->id();

       auth()->user()->projects()->create($attributes);

       //  Project::create($attributes);
        // Project::create(request(['title', 'description']));


        return redirect ('/projects');

    }

    public function show(Project $project)
    {
        // $project = Project::findOrFail(request('project'));

        return view('projects.show', compact('project'));
    }
}
