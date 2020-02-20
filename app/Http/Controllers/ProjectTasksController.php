<?php

namespace App\Http\Controllers;

use App\Project;
use App\Task;
use Illuminate\Http\Request;

class ProjectTasksController extends Controller
{
    public function store(Project $project)
    {

        // if(auth()->user()->id != $project->owner_id){

            $this->authorize('update', $project);

            //the auth check just below was removed when we switch to policy and
            // register it in the authserviceprovider

        //     if(auth()->user()->isNot($project->owner)){

        //     abort(403, 'This is not your project my dear');
        // }

        request()->validate(['body' =>'required']);

        $project->addTask(request('body'));

        return redirect($project->path());
    }

    public function update(Project $project, Task $task)
    {
        $this->authorize('update', $task->project);

            //the auth check just below was removed when we switch to policy and
            // register it in the authserviceprovider

        // if(auth()->user()->isNot($task->project->owner)){

        //     abort(403);
        // }

        request()->validate([
            'body' => 'required',
        ]);

        $task->update([
            'body' => request('body'),
            'completed' => request()->has('completed'),
        ]);

        return redirect($project->path());
    }

    
}
