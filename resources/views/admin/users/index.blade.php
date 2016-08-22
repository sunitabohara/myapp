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
	<div class="container spark-screen">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="panel-default"> <a class="btn-small btn-info pull-right" href="{{ URL::to('admin/users/create') }}">Create a User</a></div>
				<div class="panel panel-default">
					<div class="panel-heading">
                        <h3 class="panel-title"><span class="label label-success">Users List</span></h3>

                    </div>

                        <div class="box-body table-responsive no-padding">
							<table class='table table-hover'>
								<thead>
									<tr>
										<th>Name</th>
										<th>Email</th>
										<th>Roles</th>
										<th>Ceareted At</th>
										<th>Actions</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($data as $key => $user)
									<tr>
										<td>{{$user->name}}</td>
										<td>{{$user->email}}</td>
										<td>
										    @if(!empty($user->roles))
                                                @foreach($user->roles as $v)
                                                    <label class="label label-success">{{ $v->display_name }}</label>
                                                @endforeach
                                            @endif
										</td>
										<td>{{$user->created_at}}</td>
										<td>

										    <a class="btn btn-primary" href="{{ route('admin.users.edit',$user->id) }}">Edit</a>
										    <a class="btn btn-small btn-danger" id = 'click' value="{{$user->id}}" href="#">Delete</a>
										</td>
									</tr>
									 @endforeach
								</tbody>
							</table>
                    	</div>
					
				</div>
			</div>
		</div>
		<meta name="_token" content="{!! csrf_token() !!}" />

	</div>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
	<script type="text/javascript" src="{{ URL::asset('js/bootbox.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('js/custom/user.js') }}"></script>

@endsection
