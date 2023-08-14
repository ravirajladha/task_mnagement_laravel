@extends('auth.layouts') 
@section('styles')
<style>
    #outer {
        width: auto;
        text-align: center;
    }

    .inner {
        display: inline-block;
    }

</style>
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}
                <a href="{{route('tasks.create')}}" class="btn btn-primary" style="float:right;">Create</a>

                </div>

                <div class="card-body">
                    @if(Session::has('alert-success'))
                    <div class="alert alert-success" role="alert">
                        {{Session::get('alert-success')}}
                    </div>
                    @endif
                    @if(Session::has('alert-info'))
                    <div class="alert alert-info" role="alert">
                        {{Session::get('alert-info')}}
                    </div>
                    @endif
                    @if(Session::has('alert-danger'))
                    <div class="alert alert-danger" role="alert">
                        {{Session::get('alert-danger')}}
                    </div>
                    @endif
                    @if ($errors->has('error'))
                    <div class="alert alert-danger">
                        {{ $errors->first('error') }}
                    </div>
                    @endif
                    @if(count($tasks) > 0)
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Title</th>
                                <th scope="col">Description</th>
                                <th scope="col">Due Date</th>
                                <th scope="col">Completed</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($tasks as $index => $task)
                            <tr>
                            <th scope="row">{{$index + 1}}</th>
                                <td>{{$task->title}}</td>
                                <td>{{$task->description}}</td>
                                <td>{{$task->due_date}}</td>
                                <td>
                                    @if($task->is_completed==1)
                                    <a class="btn btn-sm btn-success" href="">Completed</a>
                                    @else
                                    <a class="btn btn-sm btn-danger" href="">Incompleted</a>

                                    @endif
                                </td>
                                <td id="outer">
                                    <a href="{{route('tasks.edit', $task->id)}}" class="inner btn btn-sm btn-info">Edit</a>
                                    <a href="{{route('tasks.show',$task->id)}}" class="inner btn btn-sm btn-success">View</a>
                                    <form action="{{route('tasks.destroy')}}" class="inner" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="id" class="inner" value="{{$task->id}}">
                                        <input type="submit" class="btn btn-sm btn-danger inner" value="Delete">
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        
                        </tbody>
                    </table>
    <!-- Display pagination links -->
 
                    @else
                    <h4>Waiting for the author to create tasks.</h4>
                    @endif
                   
{{ $tasks->onEachSide(1)->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection