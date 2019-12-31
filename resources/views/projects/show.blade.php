@extends('layouts.app')

@section('content')

<header class="flex items-center mb-3 py-4">

    <div class="flex justify-between items-end w-full">

    <p class="text-gray-700 text-sm font-normal">

        <a href="/projects" class="text-gray-700 text-sm font-normal no-underline"> My Projects</a> / {{$project->title}}
    </p>
    <a href="/projects/create" class="button bg-blue-400 shadow-md hover:bg-blue-700 text-white font-bold py-2 px-4 rounded no-underline">New Project</a>
    </div>
</header>

<main>
    <div class="lg:flex -mx-3">
        <div class="lg:w-3/4 px-3 mb-6">

         <div class="mb-8">
                <h2 class="text-gray-700 text-lg font-normal mb-3">Tasks</h2>

            {{-- tasks --}}
            @foreach ($project->tasks as $task)
                <div class="bg-white p-4 rounded-lg shadow-md mb-3">
                <form action="{{$task->path()}}" method="POST">
                    @method("PATCH")
                    @csrf
                        <div class="flex">
                            <input type="text" value="{{$task->body}}" name="body" class="w-full {{$task->completed ? 'line-through text-gray-500': ''}}">
                            <input type="checkbox" name="completed" id="" onchange="this.form.submit()" {{$task->completed ? 'checked' : ''}}>
                        </div>
                    </form>
                </div>

            @endforeach
            <div class="bg-white p-4 rounded-lg shadow-md mb-3">

                    <form action="{{$project->path() . '/tasks'}}" method="POST">
                        @csrf
                        <input type="text" placeholder=" Add a new task" class="w-full" name="body">
                    </form>
                </div>
         </div>

         <div>
            <h2 class="text-gray-700 text-lg font-normal mb-3">General Notes</h2>

                {{-- General Notes --}}
                <textarea class="bg-white p-4 rounded-lg shadow-md w-full" style="min-height:200px">Lorem Ipsum</textarea>
            </div>
        </div>

        <div class="lg:w-1/4 px-3">

                @include('projects.card')

        </div>
    </div>
</main>

@endsection
