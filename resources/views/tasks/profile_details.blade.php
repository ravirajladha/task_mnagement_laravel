@extends('auth.layouts') 
@section('content')
<?php
// Your PHP code to fetch and set $name and $email variables here
$name = "John Doe";
$email = "john.doe@example.com";
?>

<!-- Include the HTML and CSS code mentioned above -->

<!-- HTML part -->
<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            Profile Details
            <a href="{{route('tasks.update_profile_details')}}" class="btn btn-primary" style="float:right;">Update</a>
        </div>
        <div class="card-body">
            <h5 class="card-title">Name: {{ session()->get('guardian_auth_user_name') }}</h5>
            <p class="card-text">Email: {{ session()->get('guardian_auth_user_name') }}</p>
        </div>
    </div>
</div>
@endsection;
