@extends("admin.admin_app")

@section("content")
<div id="main">
	<div class="page-header">
		
		
		<h2>All Order List</h2>
         
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
         
        <table id="temp" class="table table-striped table-hover dt-responsive" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>Date</th>
                <th class="hidden">id</th>
                <th>order id</th>
                <th>User Name</th>
                <th>Mobile</th>
                <th>Email</th>
                <th>Restaurants </th>
                <th>Menu Name</th>
                <th>Menu Description</th>
                <th>Package Type</th>
                <th>Quantity</th>
                <th>Item Price</th>
                <th>Total Price</th>
                <th>Paymet Mode</th>
                <th>Payment Status</th>
                <th>Address</th>
                <th>Status</th>                           
                <th class="text-center width-100">Action</th>
            </tr>
            </thead>

            <tbody>
            @foreach($order_list as $i => $order)
            <tr>
                <td>{{ date('d-m-Y',strtotime($order->created_at))}}</td>
                <td class="hidden">{{ $order->id }}</td>
                <th>{{ $order->order_id }}</th>
                <td><a href="{{ url('admin/users/adduser/'.$order->user_id) }}">{{ \App\User::getUserFullname($order->user_id) }}</a></td>
                <td>{{ \App\User::getUserInfo($order->user_id)->mobile }}</td>
                <td>{{ \App\User::getUserInfo($order->user_id)->email }}</td>
                <td><a href="{{ url('admin/restaurants/view/'.$order->restaurant_id) }}" class="text-regular">{{ \App\Restaurants::getRestaurantsInfo($order->restaurant_id)->restaurant_name }}</a>
                </td>
                <?php 
                    $restaurant_info = \App\Menu::getMenunfo($order->menu_id);
                 ?>
                <td>{{ $restaurant_info->menu_name }}</td>
                <td>{{ $restaurant_info->description }}</td>
                <td>{{ $order->package_type }}</td>
                <td>{{ $order->quantity }}</td>
                <td>{{getcong('currency_symbol')}}{{ \App\Menu::getMenunfo($order->menu_id)->price }}</td>
                <td>{{getcong('currency_symbol')}}{{ $order->item_price }}</td>
                <td>{{ $order->payment_mode }}</td>
                <?php
                    $payment_status = "";
                    if($order->payment_mode == "paytm")
                    {
                        $payment_status = explode(",", $order->payment_extra_data);
                        $payment_status = explode("=",$payment_status[0]);
                        $payment_status = $payment_status[0];
                    }
                    elseif($order->payment_mode == "payU")
                    {
                        $payment_status = explode(",", $order->payment_extra_data);
                        $payment_status = explode(":",$payment_status[6]);
                        $payment_status = $payment_status[1];
                    }
                    else
                        $payment_status = $order->payment_extra_data;
                ?>
                <td>{{ $payment_status }}</td>
                <?php $address = \App\Address::where('id',$order->address_id)->first() ?>
                <td>{{ $address->flat_no . ", " . $address->colony . ", " . $address->area . ", " . $address->lanmark . ", " . $address->city . ", " . $address->pincode . ", " .  $address->state }} @if( $order->address_id)<a href="{{ url('admin/users/editaddress/'.$order->address_id) }}"><i class="md md-edit"></i></a>@endif</td>
                <td>{{ $order->status }}</td>
                <td class="text-center">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default-dark dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            Actions <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right" role="menu"> 
                            <li><a href="{{ url('admin/restaurants/view/'.$order->restaurant_id.'/orderlist/'.$order->id.'/Pending') }}"><i class="md md-lock"></i> Pending</a></li>
                            <li><a href="{{ url('admin/restaurants/view/'.$order->restaurant_id.'/orderlist/'.$order->id.'/Processing') }}"><i class="md md-loop"></i> Processing</a></li>
                            <li><a href="{{ url('admin/restaurants/view/'.$order->restaurant_id.'/orderlist/'.$order->id.'/Completed') }}"><i class="md md-done"></i> Completed</a></li>
                            <li><a href="{{ url('admin/restaurants/view/'.$order->restaurant_id.'/orderlist/'.$order->id.'/Cancel') }}"><i class="md md-cancel"></i> Cancel</a></li>
                            <li><a href="{{ url('admin/restaurants/view/'.$order->restaurant_id.'/orderlist/'.$order->id) }}"><i class="md md-delete"></i> Delete</a></li>
                        </ul>
                    </div> 
                </td> 
            </tr>

           @endforeach             
            </tbody>
        </table>
         
        <script type="text/javascript">
            $(document).ready(function() {
                // return false;
                $('#temp').dataTable({
                    "order": [[ 1, "desc" ]]
                });

                // $('#temp').dataTable();

            } );
         </script>

    </div>
    <div class="clearfix"></div>
</div>

</div>

@endsection