
@extends('auth.layouts') 
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create Tasks</div>

                <div class="card-body">

                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <form method="POST" action="{{route('tasks.update')}}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="created_by" value="{{ session()->get('guardian_auth_userid')}}" />
                        <input type="hidden" name="id" value="{{$task->id}}">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Title*</label>
                            <input type="text" class="form-control" placeholder="{{$task->title}}" value="{{$task->title}}" name="title">
                            <small id="emailHelp" class="form-text text-muted">Enter proper title for your tasks</small>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Description*</label>
                            <textarea type="text" class="form-control" placeholder="{{$task->description}}"  name="description" cols="5" rows="5">{{$task->description}}</textarea>
                            <small id="emailHelp" class="form-text text-muted">Enter proper description for your tasks</small>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Due Date*</label>
                            <input type="datetime" class="form-control" name="due_date" value="{{$task->due_date}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Status*</label>
                            <select name="is_completed" class="form-control"> 
                                <option disabled selected>Select Option</option>
                                <option value="1" <?php if($task->is_completed==1){ echo "selected"; } ?>>Completed</option>
                                <option value="0" <?php if($task->is_completed==0){ echo "selected"; } ?>>In Completed</option>
                            </select>
                        </div>
                        </br>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection