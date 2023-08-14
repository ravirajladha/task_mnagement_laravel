@extends('auth.layouts') 
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">  Task Show Dash: <a href="{{url()->previous()}}" class="btn btn-sm btn-info" style="float:right;">Go Back</a></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

              
                 <b>Title: {{$task->title}}</b>
                <b>Description: {{$task->description}}</b>
                <b> Due Date: {{$task->due_date}}</b>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
