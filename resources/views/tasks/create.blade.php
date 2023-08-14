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
                    <form method="POST" action="{{route('tasks.store')}}">
                        @csrf

                        <input type="hidden" name="created_by" value="{{ session()->get('guardian_auth_userid')}}" />
                        <div class="form-group">
                            <label for="exampleInputEmail1">Title*</label>
                            <input type="text" class="form-control" placeholder="Enter title" name="title">
                            <small id="emailHelp" class="form-text text-muted">Enter proper title for your tasks</small>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Description*</label>
                            <textarea type="text" class="form-control" placeholder="Enter description" name="description" cols="5" rows="5"></textarea>
                            <small id="emailHelp" class="form-text text-muted">Enter proper description for your tasks</small>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Due Date*</label>
                            <input type="date" class="form-control" name="due_date">
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