@extends('layouts.app')

@section('content')
    <form method="post" action="/projects">
    @csrf

    <h1 class="heading is-1">Create Projects</h1>

        <div class="field">
            <label for="title" class="label">Title</label>
                <div class="control">
                    <input type="text" class="input" name="title" placeholder="title">
                </div>
        </div>

        <div class="field">
          <label for="description" class="label">Description</label>

          <div class="control">
          <textarea class="textarea" name="description" id=""></textarea>
          </div>
        </div>

        <div class="field">
            <div class="control">
                <button type="submit" class="button is-link">Create project</button>
                <a href="/projects">cancel</a>
            </div>
        </div>
    </form>
    @endsection
