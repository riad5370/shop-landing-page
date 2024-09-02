@extends('admin.include.master')
@push('css')
<style>
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
}

.container {
    max-width: 800px;
    margin: 20px auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 10px;
    background-color: #FFFFFF;
}

.invoice-header {
    text-align: center;
    margin-bottom: 20px;
}

.invoice-details {
    margin-bottom: 20px;
}

.invoice-details table {
    width: 100%;
    border-collapse: collapse;
}

.invoice-details th,
.invoice-details td {
    padding: 10px;
    border-bottom: 1px solid #ccc;
}

.invoice-items {
    margin-bottom: 20px;
}

.invoice-items table {
    width: 100%;
    border-collapse: collapse;
}

.invoice-items th,
.invoice-items td {
    padding: 10px;
    border-bottom: 1px solid #ccc;
}

.invoice-total {
    margin-top: 20px;
    text-align: right;
}

.invoice-total p {
    margin: 5px 0;
}

.customer-info, .company-info {
    width: 50%;
    float: left;
}

.customer-info h3, .company-info h3 {
    margin-top: 0;
    margin-bottom: 10px;
}

.customer-info p, .company-info p {
    margin: 0;
}

.clearfix::after {
    content: "";
    display: table;
    clear: both;
}
</style>
@endpush
@section('body')
<div class="container">
    <div class="invoice-header">
        <h2 style="display: inline;">Invoice</h2>
        <div class="widget-toolbar hidden-480">
            {{-- <a href="{{ route('customerbill.invoice',$order_info->id)}}">
                <i class="ace-icon fa fa-print"></i>
            </a> --}}
        </div>
        {{-- <a href="{{route('customerbill.invoice',$customerInfo->id)}}" style="margin-left: 50px;">download</a> --}}
    </div>
    <div class="invoice-details">
        <table>
            <tr>
                <th>Invoice Number:</th>
                <td>{{ $order_info->order_id }}</td>
            </tr>
            <tr>
                <th>Date:</th>
                <td>{{ $order_info->created_at->format('d-m-y') }}</td>
            </tr>
        </table>
    </div>

    <div class="customer-info">
        <h3>Customer Information</h3>
        <p>Customer Name: <strong>{{$customerInfo->name}}</strong></p>
        <p>Address: <strong>{{$customerInfo->address}}</strong></p>
        <p>Email: <strong>{{$customerInfo->email}}</strong></p>
        <p>Phone: <strong>{{$customerInfo->phone}}</strong></p>
    </div>

    <div class="company-info">
        <h3>Company Information</h3>
        <p>Company Name: Your Company Name</p>
        <p>Address: 456 Oak Street, City, State, ZIP</p>
        <p>Email: info@example.com</p>
        <p>Phone: (456) 789-0123</p>
    </div>
    
    <div class="clearfix"></div>
    
    <div class="invoice-items">
        <h3>Invoice Items</h3>
        <table>
            <tr>
                <th style="text-align: center;">Description</th>
                <th style="text-align: center;">Price</th>
                <th style="text-align: center;">Quantity</th>
                <th style="text-align: center;">Total</th>
            </tr>
            @php
              $sub = 0;
            @endphp
            @foreach ($order_product as $product_info)
            <tr>
                <td style="text-align: center;">{{$product_info->product->name}}</td>
                <td style="text-align: center;">{{ $product_info->price }}</td>
                <td style="text-align: center;">{{ $product_info->quantity }}</td>
                <td style="text-align: center;">{{ $product_info->price*$product_info->quantity }}</td>
            </tr>
            @php
              $sub += $product_info->price*$product_info->quantity;
            @endphp
            @endforeach
        </table>
    </div>
    
    <div class="invoice-total" style="margin-right: 20px!important;">
        <p><strong>Subtotal:</strong> {{ $sub }}</p>
        <p><strong>discount(-):</strong> {{ $order_info->discount }}</p>
        <p style="position: relative;"> <strong>Charge(+):</strong> {{ $order_info->charge }}
          <span style="position: absolute; bottom: -5px; left: 0; width: 100%; border-bottom: 1px dotted black;"></span>
        </p>
        <p><strong>Total:</strong> {{ $order_info->total}}</p>
       </div>
      <div style="margin-bottom: 10px;"><strong>Payment Status: <i>{{ $order_info->payment_method == 1? 'Unpaid':''}}</i></strong></div>
      
  <span>Thank You!</span>
</div>
@endsection
