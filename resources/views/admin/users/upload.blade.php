@extends('layouts.app')

@section('contentheader_title')
{{ $page_title }}
@endsection
@section('breadcrumb')


<li><a href="#"><i class="fa fa-user"></i> Users</a></li>

@endsection
@section('htmlheader_title')
Users
@endsection


@section('main-content')
            {!! Form::open(
            array(
            'route' => 'admin.users.storeImage',
            'class' => 'form',
            'novalidate' => 'novalidate',
            'files' => true)) !!}


<div class = "form-group">

                @php

                     $url ='//localhost/myapp/public/files/images/users/'.$id.'/image.jpg';
                     $path = getFullFolderDirPathFromId('users', $id);
                     $img_thum_path 	= $path . '/profile/thumb/';
                     $img_path 	= $path . '/profile/';
                     $picname 	= 'image.jpg';



                 @endphp

                 @if (File::exists($img_path.$picname ))

                        <a href="//localhost/myapp/public/files/images/users/{{$id}}/image.jpg "><img src="{{asset('//localhost/myapp/public/files/images/users/'.$id.'/image.jpg?thumb')}}" class="img" alt="User Image" /></a>
                   @endif




            <div class="form-group">
                {!! Form::label('User Image') !!}
                {!! Form::file('image', null) !!}
            </div>
            <div>
                 {!! Form::hidden('id', $id) !!}
            </div>
            <div class="form-group">
                {!! Form::submit('Upload!',array('class' => 'btn-success')) !!}
            </div>
            {!! Form::close() !!}
            </div>
@endsection