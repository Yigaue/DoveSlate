<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Integer;

class Project extends Model
{
    protected $guarded = [];

    public function path()
    {
        return "/projects/{$this->id}";
    }

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function addTask($body)
    {
       return $this->tasks()->create(compact('body'));
        //OR return $this->task()->create(['body' =>$body])

    }

    public function activity()

    {

        return $this->hasMany(Activity::class);
    }

    // Not part of the project
    // public function add($par1, $par2) {

    //     return $par1 . " " . $par2;
    // }

    // public function multiply($x, $y){
    //     if (!is_int($x) || !is_int($y)) {
    //         return "we need ints";
    //     }
    //     return $x * $y;

    // }
}
