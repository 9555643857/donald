@extends("admin.admin_app")

@section("content")
<div id="main">
	<div class="page-header">
		
		<div class="pull-right">
			<a href="{{URL::to('admin/users/adduser')}}" class="btn btn-primary">Add User <i class="fa fa-plus"></i></a>
		</div>
		<h2>Users</h2>
	</div>
	@if(Session::has('flash_message'))
				    <div class="alert alert-success">
				    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
<span aria-hidden="true">&times;</span></button>
				        {{ Session::get('flash_message') }}
				    </div>
	@endif
     
<div class="panel panel-default panel-shadow">
    <div class="panel-body">
         
        <table id="data-table" class="table table-striped table-hover dt-responsive" cellspacing="0" width="100%">
            <thead>
	            <tr>	               
	               
	                <th>First Name</th>
	                <th>Last Name</th>
	                <th>Mobile Number</th>
	                <th>Email</th>
	                <th>Address</th>
	                <th>Status</th> 
	                <th class="text-center width-100">Action</th>
	            </tr>
            </thead>

            <tbody>
            @foreach($allusers as $i => $users)
         	   <tr>
            	  
              
                <td>{{ $users->first_name }}</td>
                <td>{{ $users->last_name }}</td>
                <td>{{ $users->mobile_no }}</td>
                <td>{{ $users->email}}</td>
                <td>{{ $users->address}}</td>
                <td>  
                                  @if($users->status==1) <span class="badge badge-success">Active</span> @endif 
                                  @if($users->status==0) <span class="badge badge-danger">Inactive</span> @endif
				</td>
                
                
                <td class="text-center">
                <div class="btn-group">
								<button type="button" class="btn btn-default-dark dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
									Actions <span class="caret"></span>
								</button>
								<ul class="dropdown-menu dropdown-menu-right" role="menu">
									 <li><a href="{{ url('admin/users/address/'.$users->id) }}"><i class="md md-edit"> </i> Addresses</a></li>
									<li><a href="{{ url('admin/users/adduser/'.$users->id) }}"><i class="md md-edit"></i> Edit Editor</a></li>
									<li><a href="{{ url('admin/users/delete/'.$users->id) }}"><i class="md md-delete"></i> Delete</a></li>
								</ul>
							</div> 
                
            </td>
                
            </tr>
           @endforeach
             
            </tbody>
        </table>
    </div>
    <div class="clearfix"></div>
</div>

</div>



@endsection