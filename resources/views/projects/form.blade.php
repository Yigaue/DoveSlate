    @csrf
   
        <div class="field mb-6">
            <label for="title" class="label text-sm mb-2 block">Title</label>
                <div class="control">
                <input type="text" class="input bg-transparent border border-grey-light rounded p-2  text-xs w-full" name="title"
                placeholder="my new awesome project"
                required
                value="{{$project->title}}">
                </div>
        </div>

        <div class="field">
          <label for="description" class="label ">Description</label>

          <div class="control">
          <textarea class="textarea text-xs p-2 rounded border border-grey-light w-full"
            required
          placeholder="describe what your project is about" 
          name="description">
            {{$project->description}}
            </textarea>
          </div>
        </div>

        <div class="field">
            <div class="control">
            <button type="submit" class="button is-link bg-blue-400 rounded text-white font-bold py-2 px-4 mt-3">{{$buttonText}}</button>
            <a href="{{$project->path()}}">cancel</a>
            </div>
        </div>

        @if($errors->any())
            <div class="field mt-6">
                @foreach ($errors->all() as $error)
                   <li class="text-sm text-red-600">{{$error}}</li> 
                @endforeach
            </div>
        @endif
