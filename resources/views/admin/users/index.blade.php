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
										<th>Ceareted At</th>
										<th>Actions</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($data as $key => $user)
									<tr>
										<td>{{$user->name}}</td>
										<td>{{$user->email}}</td>
										<td>{{$user->created_at}}</td>
										<td></td>
									</tr>
									 @endforeach
								</tbody>
							</table>
                    	</div>
					
				</div>
			</div>
		</div>
	</div>
	
@endsection
