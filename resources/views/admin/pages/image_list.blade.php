@extends("admin.admin_app")

@section("content")
<div id="main">
	<div class="page-header">
		<div class="pull-right">
			<a href="http://donalds.in/admin/restaurants/view/{{$restaurant_id}}/images/addimage" class="btn btn-primary">Add <i class="fa fa-plus"></i></a>
		</div>
		
		<h2>Restaurant Images</h2>
        <a href="{{ URL::to('admin/restaurants/view/'.$restaurant_id) }}" class="btn btn-default-light btn-xs"><i class="md md-backspace"></i> Back Restaurant</a>
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
                <th>Date</th>
                               
                <th>image</th>                           
                
            </tr>
            </thead>

            <tbody>
            @foreach($image_list as $i => $image)
            <tr>
                <td>{{ date('m-d-Y',$image->created_at)}}</td>
               
                 
                <td><img src="http://donalds.in/upload/images/{{ $image->img }}" width="80" class="img-circle border-white" alt="menu"></td>
               
            </tr>
           @endforeach
             
            </tbody>
        </table>
         
    </div>
    <div class="clearfix"></div>
</div>

</div>

@endsection