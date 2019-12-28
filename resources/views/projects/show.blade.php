@extends('layouts.app')

@section('content')
<h1>My Projects</h1>
<h2>{{$project->title}}</h2>

<div>{{$project->description}}</div>

<a href="/projects">Go Back</a>
@endsection
