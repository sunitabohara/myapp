@extends('layouts.app')

@section('contentheader_title')
	Users
@endsection
@section('breadcrumb')


        <li><a href="#"><i class="fa fa-user"></i> Users</a></li>
   
@endsection
@section('htmlheader_title')
	Users
@endsection


@section('main-content')

<div class="col-lg-12">
    @foreach ($num_files as $key => $file)
@php
$img =(explode($folder_path,$file));
@endphp

        <div class="img col-lg-4">

          <a target="_blank" href="fjords.jpg">
            <img src="//localhost/myapp/public/files/img/{{$img[1]}}" alt="Fjords" width="300" height="200">

          </a>

        </div>
    @endforeach
</div>

<style>
div.img {
    margin-bottom: 15px;

    float: left;
}
</style>
@endsection
