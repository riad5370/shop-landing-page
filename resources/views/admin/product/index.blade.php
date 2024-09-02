@extends('admin.include.master')

@section('body')
<div style="background-color: #3498DB; width:100%;height:190px;">
    <div class="col-md-6">
    <h2 style="margin: 0; color: white; text-shadow: 2px 2px 4px #000000; padding: 12px 50px 0 100px;">Product Information</h2>
    <h6 style="margin-top: 2px; padding: 0 50px 0 100px;">
        <ul class="breadcrumb" style="padding: 0; margin:0;">
            <li><a href="{{ route('dashboard') }}" style="color: white;">Dashboard</a></li>
            <li class="active">Product</li>
        </ul>
    </h6>
</div>
<div class="col-md-6">
    <form class="col-md-offset-3 text-right">
        <a href="{{route('products.create')}}" class="align-items-center btn btn-theme btn-success" style="margin-top:32px;">
            <i class="menu-icon fa fa-plus"></i> Add New
        </a>
    </form>
</div>
    <div class="col-xs-12">
        <div class="clearfix">
            <div class="pull-right tableTools-container"></div>
        </div>
        <?php
        $productCount = $products->count();    
        ?>
        <div class="table-header">
            All Products ({{ $productCount }})
        </div>
        <div>
            <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="center">S/N</th>
                        <th class="center">Name</th>
                        <th class="center">Category</th>
                        <th class="center">Brand</th>
                        <th class="center">Price</th>
                        <th class="center">Discount</th>
                        <th class="center">Preview</th>
                        <th class="center">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @php
                        $sn = 1;
                    @endphp
                    @foreach ($products as $product)
                        <tr role="row" class="{{ $loop->odd ? 'odd' : 'even' }}">
                            <td class="center">{{ $sn++ }}</td>
                            <td class="center">{{ $product->name ?: 'null' }}</td>
                            <td class="center">{{ $product->category }}</td>
                            
                            <td class="center">{{ $product->brand }}</td>
                            <td class="center">{{ $product->price ?: 'null' }}</td>
                            <td class="center">{{ $product->discount ?: 'null' }}</td>
                            <td class="center">
                                <img width="50" src="{{ asset('images/products/preview/' . $product->preview) }}" alt="">
                            </td>
                            <td class="center">
                                <div class="hidden-sm hidden-xs action-buttons">
                                    <a class="green" href="{{ route('products.edit', $product->id) }}">
                                        <i class="ace-icon fa fa-pencil bigger-130"></i>
                                    </a>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" id="delete-form-{{ $product->id }}" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    
                                    <i class="red ace-icon fa fa-trash-o bigger-130" onclick="confirmAndSubmit({{ $product->id }})"></i>
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
    <!-- page specific plugin scripts -->
    <script src="{{ asset('admin-asset/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin-asset/js/jquery.dataTables.bootstrap.min.js') }}"></script>
    <script type="text/javascript">
        jQuery(function($) {
            //initiate dataTables plugin
            var myTable = 
            $('#dynamic-table')
            .DataTable( {
                bAutoWidth: false,
                "aoColumns": [
                  { "bSortable": false },
                  null, null, null, null, null,null, 
                  { "bSortable": false }
                ],
                
            } );
        })
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
