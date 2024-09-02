@extends('admin.include.master')
@section('body')
<div style="width:50%; margin: 0 auto;">
    <h2 style="padding:30px;margin-top: 50px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); text-align: center;">
        Hi! <span class="text-danger">{{ Auth()->user()->name }}</span> <br> Welcome This Dashboard
    </h2>
</div>
@endsection




