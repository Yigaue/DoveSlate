@extends('layouts.app')

@section('content')

<div class="flex items-center mb-3">
    <a href="/projects/create">Create New Project</a>
</div>

<div class="flex flex-wrap">
    @forelse ($projects as $project)
    <div class="bg-white m-3 rounded shadow-md w-1/3 p-3" style="height:200px; width:300px">
    <h3 class="font-normal text-xl mb-6">{{$project->title}}</h3>
    <div class="text-gray-600"> {{str_limit($project->description, 100)}}</div>
    </div>
    @empty

    <div>No projects yet</div>

    @endforelse
</div>

@endsection
