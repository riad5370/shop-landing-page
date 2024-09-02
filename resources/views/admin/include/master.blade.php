<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>Dashboard</title>
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<meta name="description" content="overview &amp; stats" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		@include('admin.include.style')
		@stack('css')
	</head>

	<body class="no-skin">
		
        @include('admin.include.header')

		<div class="main-container ace-save-state" id="main-container">
			<script type="text/javascript">
				try{ace.settings.loadState('main-container')}catch(e){}
			</script>

			@include('admin.include.sideber')

			<div class="main-content">
				<div class="main-content-inner">
					@include('admin.include.navber')

					@yield('body')<!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->

			@include('admin.include.footer')

			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
			</a>
		</div><!-- /.main-container -->

		<!-- basic scripts -->

		<!--[if !IE]> -->
		@include('admin.include.script')
		
	</body>
</html>
