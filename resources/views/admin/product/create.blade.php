@extends('admin.include.master')
@push('css')
<link rel="stylesheet" href="{{asset('admin-asset')}}/css/chosen.min.css" />
<!-- ace styles -->
<link rel="stylesheet" href="{{asset('admin-asset')}}/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@section('body')
<div style="background-color: #3498DB; width:100%;height:190px;">
    <h2 style="margin: 0; color: white; text-shadow: 2px 2px 4px #000000; padding: 12px 50px 0 100px;">Add New Product</h2>
    <h6 style="margin-top: 0px; padding: 0 50px 0 100px;">
        <ul class="breadcrumb" style="padding: 0; margin:0;">
            <li><a href="{{ route('dashboard') }}" style="color: white;">Dashboard</a></li>
            <li class="active">Add Product</li>
        </ul>
    </h6>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
<div class="main-content-inner font">
    <form action="{{route('products.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-md-12 col-sm-12">
                    <div class="widget-box">
                        <div class="widget-header">
                            <h4 class="widget-title">Product Information</h4>
                        </div>
                        <div class="widget-body">
                            <div class="widget-main">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label no-padding-right" for="name">Product Name :</label>
                                                <div>
                                                    <input type="text" name="name" value="{{old('name')}}" id="name" placeholder="Product Name" class="form-control" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label no-padding-right" for="name">Category :</label>
                                                <div>
                                                    <input type="text" name="category" value="{{old('category')}}" id="name" placeholder="category" class="form-control" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label no-padding-right" for="price">Brand :</label>
                                                <div>
                                                    <input type="text" name="brand" value="{{old('brand')}}" placeholder="brand" class="form-control" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label no-padding-right" for="price">Price :</label>
                                                <div>
                                                    <input type="number" name="price" id="price" value="{{old('price')}}" placeholder="&#2547; Price" class="form-control" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label no-padding-right" for="discount">Discount :</label>
                                                <div>
                                                    <input type="number" value="{{old('discount')}}" name="discount" id="discount" placeholder="&#2547; Discount %" class="form-control" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label no-padding-right" for="discount">Product Video Link :</label>
                                            <div>
                                                <input type="text" value="{{old('vdo_link')}}" name="vdo_link" id="vdo_link" placeholder="link" class="form-control" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <!-- Closing tag for the first div -->
            <div class="row">
                <div class="col-xs-12 col-md-12 col-sm-12">
                    <div class="widget-box">
                        <div class="widget-header">
                            <h4 class="widget-title">Product Description</h4>
                        </div>
                        <div class="widget-body">
                            <div class="widget-main">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="green col-sm-3 control-label no-padding-right" for="form-field-1">Long Description:</label>
                                            <div class="col-sm-9">
                                                <!-- Long Description content here -->
                                                <div class="widget-box">
                                                    <div class="widget-body">
                                                        <div class="widget-main no-padding">
                                                           <textarea name="long_desp" id="summernote1" cols="30" rows="10">{{old('long_desp')}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-12 col-xs-6">
                    <div class="widget-box">
                        <div class="widget-header">
                            <div class="row">
                                <div class="col-md-6 col-6 col-xs-6">
                                    <h4 class="widget-title">Product Photo</h4>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center" style="margin-top: 15px; margin-left: 10px;">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label no-padding-right" for="image">Preview Image :</label>
                                    <div class="col-sm-9">
                                        <!-- Preview Image content here -->
                                        <div class="col-sm-5">
                                            <div class="widget-body">
                                                <div class="form-group">
                                                    <div class="col-xs-12 col-md-12">
                                                        <label class="ace-file-input ace-file-multiple">
                                                            <input type="file" name="preview" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])" />
                                                            <span class="ace-file-container" data-title="Choose Preview Image...">
                                                                <span class="ace-file-name" data-title="No File ...">
                                                                    <i class="ace-icon ace-icon fa fa-cloud-upload"></i>
                                                                </span>
                                                            </span>
                                                            <a class="remove" href="#"><i class="ace-icon fa fa-times"></i></a>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="help-inline col-xs-12 col-sm-7">
                                            <label class="middle">
                                                <img height="145" id="blah" width="155" src="{{ asset('images/temp.jpg') }}" alt="Image">
                                            </label>
                                        </span>
                                    </div>
                                </div>
                            </div>
        
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label no-padding-right" for="image">Gallery Image :</label>
                                    <div class="col-sm-9">
                                        <!-- Gallery Image content here -->
                                        <div class="col-sm-5">
                                            <div class="widget-body">
                                                <div class="form-group">
                                                    <div class="col-xs-12 col-md-12">
                                                        <label class="ace-file-input ace-file-multiple">
                                                            <input type="file" name="thumbnail[]" multiple onchange="previewImages(this)" />
                                                            <span class="ace-file-container" data-title="Choose Thumbnail Images...">
                                                                <span class="ace-file-name" data-title="No Files...">
                                                                    <i class="ace-icon ace-icon fa fa-cloud-upload"></i>
                                                                </span>
                                                            </span>
                                                            <a class="remove" href="#"><i class="ace-icon fa fa-times"></i></a>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="help-inline col-xs-12 col-sm-7">
                                            <div id="image-preview-container">
                                                <label class="middle">
                                                    <img height="145" id="blah" width="155" src="{{ asset('images/temp.jpg') }}" alt="Image">
                                                </label>
                                            </div>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
        
        <div class="clearfix form-actions">
            <div class="col-md-offset-3 col-md-9">
                <button type="submit" class="btn btn-sm btn-info">
                    <i class="ace-icon fa fa-check bigger-110"></i>
                    Save
                </button>
                <button type="button" class="btn btn-sm btn-danger" id="cancelButton">
                    <i class="ace-icon fa fa-times bigger-110"></i> 
                    Cancel
                </button>
            </div>
        </div>
    </div>
    </form>
</div>
</div>
@endsection
@push('js')
<script src="{{asset('admin-asset')}}/js/bootbox.js"></script>
<script src="{{asset('admin-asset')}}/js/chosen.jquery.min.js"></script>
<!-- Summernote JS -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- inline scripts related to this page -->
<script type="text/javascript">
    jQuery(function($){
        if(!ace.vars['touch']) {
            $('.chosen-select').chosen({allow_single_deselect:true}); 

            // $('#chosen-multiple-style .btn').on('click', function(e){
            //     var target = $(this).find('input[type=radio]');
            //     var which = parseInt(target.val());
            //     if(which == 2) $('#form-field-select-4').addClass('tag-input-style');
            //      else $('#form-field-select-4').removeClass('tag-input-style');
            // });
        }

    });
</script> 

<script>
    $('#summernote').summernote({
      placeholder: 'Write Product Short Description',
      tabsize: 2,
      height: 120,
      toolbar: [
        ['style', ['style']],
        ['font', ['bold', 'underline', 'clear']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['table', ['table']],
        ['insert', ['link', 'picture', 'video']],
        ['view', ['fullscreen', 'codeview', 'help']]
      ]
    });
  </script>

<script>
    $('#summernote1').summernote({
      placeholder: 'Write Product Long Description',
      tabsize: 2,
      height: 120,
      toolbar: [
        ['style', ['style']],
        ['font', ['bold', 'underline', 'clear']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['table', ['table']],
        ['insert', ['link', 'picture', 'video']],
        ['view', ['fullscreen', 'codeview', 'help']]
      ]
    });
  </script>

<script>
    function previewImages(input) {
        var previewContainer = document.getElementById('image-preview-container');
        previewContainer.innerHTML = ''; // Clear previous previews

        if (input.files) {
            for (var i = 0; i < input.files.length; i++) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    var imgElement = document.createElement('img');
                    imgElement.setAttribute('height', '50'); // Adjusted height
                    imgElement.setAttribute('width', '50');  // Adjusted width
                    imgElement.src = e.target.result;

                    previewContainer.appendChild(imgElement);
                };

                reader.readAsDataURL(input.files[i]);
            }
        }
    }
</script>
<script>
    document.getElementById('cancelButton').addEventListener('click', function() {
        location.reload();
    });
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

{{-- //Getting subcategory information --}}
<script>
    $('#categori_id').change(function(){
        var category_id = $(this).val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url:'/getsubcategory',
            type:'POST',
            data:{'category': category_id},
            success:function(data){
                $('#subcategory').html(data);
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
    $('.js-example-basic-single').select2();
});
</script>
@endpush
