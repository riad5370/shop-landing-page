@extends('admin.include.master')
@push('css')
    <!-- Custom CSS for dropdown and submenu -->
    <style>
        .dropdown-menu .dropdown-submenu {
            position: relative;
        }

        .dropdown-menu .dropdown-submenu > .dropdown-menu {
            left: -100%;
            top: 0;
            margin-top: -1px;
            display: none;
            position: absolute;
            z-index: 1000; /* Ensure submenu appears above everything */
        }

        .dropdown-menu .dropdown-submenu:hover > .dropdown-menu {
            display: block;
        }
    </style>
@endpush

@section('body')
<div style="background-color: #3498DB; width:100%;height:190px;">
    <div class="col-md-6">
    <h2 style="margin: 0; color: white; text-shadow: 2px 2px 4px #000000; padding: 12px 50px 0 100px;">Orders Information</h2>
    <h6 style="margin-top: 2px; padding: 0 50px 0 100px;">
        <ul class="breadcrumb" style="padding: 0; margin:0;">
            <li><a href="{{ route('dashboard') }}" style="color: white;">Dashboard</a></li>
            <li class="active">Orders</li>
        </ul>
    </h6>
</div>
@php
   $totalOrder = $orders->count();  
@endphp
<div class="col-xs-12">
    <div class="clearfix">
        <div class="pull-right tableTools-container"></div>
    </div>
    <div class="table-header">
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px 0; background-color: #f8f8f8; border: 1px solid #ddd; border-radius: 5px;">
            <span style="margin: 0 20px; font-size: 16px; font-weight: bold; color: #333;">All Orders ({{$totalOrder}})</span>
            <span style="margin: 0 20px; font-size: 16px; font-weight: bold; color: #333;">Pending Orders ({{$pendingOrders}})</span>
            <span style="margin: 0 20px; font-size: 16px; font-weight: bold; color: #333;">Processing Orders ({{$processingOrders}})</span>
            <span style="margin: 0 20px; font-size: 16px; font-weight: bold; color: #333;">Completed Orders ({{$deliveryOrders}})</span>
        </div>
        
    </div>
    
    <div class="">
        <table id="dynamic-table" class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th class="center">S/N</th>
                    <th class="center">OrderId</th>
                    <th class="center">Date</th>
                    <th class="center">Total</th>
                    <th class="center">Payment</th>
                    <th class="center">Status</th>
                    <th class="center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $sl=>$order)
                    <tr>
                        <td class="center">{{ $sl+1 }}</td>
                        <td class="center">{{ $order->order_id }}</td>
                        <td class="center">{{ $order->created_at->diffForHumans() }}</td>
                        <td class="center">{{ $order->total }}</td>
                        <td class="center">{{ $order->payment_method == 1 ? 'Bkash' : 'Unpaid' }}</td>
                        <td class="center">
                            @php
                                $status_labels = [
                                    1 => 'Pending',
                                    2 => 'Processing',
                                    3 => 'Packaging',
                                    4 => 'Ready to Deliver',
                                    5 => 'Shipped',
                                    6 => 'Delivered'
                                ];
                                $status_classes = [
                                    1 => 'label-light',
                                    2 => 'label-primary',
                                    3 => 'label-warning',
                                    4 => 'label-success',
                                    5 => 'label-danger',
                                    6 => 'label-dark'
                                ];
                                echo '<span class="label ' . $status_classes[$order->status] . '">' . $status_labels[$order->status] . '</span>';
                            @endphp
                        </td>
                        <td class="center">
                            <a href="{{ route('order.details', $order->id) }}" class="btn btn-info btn-xs"><i class="fa fa-eye"></i></a>
                            <div class="dropdown" style="display: inline-block; position: relative;">
                                <button class="btn btn-success btn-xs dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-cog"></i> <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li class="dropdown-submenu">
                                        <a tabindex="-1" href="#">Status</a>
                                        <ul class="dropdown-menu">
                                            @foreach($status_labels as $key => $value)
                                                <li>
                                                    <form action="{{ route('order.status') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="status" value="{{ $order->order_id . ',' . $key }}">
                                                        <button type="submit" class="btn btn-link">{{ $value }}</button>
                                                    </form>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                   <li>
                                    <a href="{{ route('delete.orders', $order->id) }}" onclick="return confirm('Are you sure you want to delete this customer?');">Delete</a>
                                   </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>
@endsection

@push('js')
<script src="{{ asset('admin-asset/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin-asset/js/jquery.dataTables.bootstrap.min.js') }}"></script>
<script type="text/javascript">
    jQuery(function($) {
        $('#dynamic-table').DataTable({
            bAutoWidth: false,
            "aoColumns": [
                { "bSortable": false },
                null, null, null, null, null,
                { "bSortable": false }
            ],
        });
    });
</script>
<script>
    function confirmAndSubmit(productId) {
        if (confirm('Are You Sure Delete This!')) {
            document.getElementById('delete-form-' + productId).submit();
        }
    }
</script>
@if (session('success'))
<script>
    Toastify({
        text: "{{ session('success') }}",
        duration: 5000,
        close: true,
        gravity: "bottom",
        position: "left",
        stopOnFocus: true,
        backgroundColor: "rgba(40, 167, 69, 0.9)"
    }).showToast();
</script>
@endif
@endpush
