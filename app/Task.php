<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded = [];

    protected $touches = ['project'];

    public static function boot()

    {
        parent::boot();

        static::created(function ($task) {

            Activity::create([
                'project_id' => $task->project->id,
                'description' => 'created_task'
                ]);

        });

        static::updated(function ($task) {

            Activity::create([
                'project_id' => $task->project->id,
                'description' => 'completed_task',
            ]);
        });

    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function path()
    {
        return "/projects/{$this->project->id}/tasks/{$this->id}";
    }
}
