@section( 'content' )


<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>@lang('dingsu.company_name')</title>

	<!-- Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

	<!-- plugins:css -->
	<link rel="stylesheet" href="{{ asset('staradmin/vendors/iconfonts/mdi/css/materialdesignicons.min.css') }}">
	<link rel="stylesheet" href="{{ asset('staradmin/vendors/iconfonts/puse-icons-feather/feather.css') }}">
	<link rel="stylesheet" href="{{ asset('staradmin/vendors/css/vendor.bundle.base.css') }}">
	<link rel="stylesheet" href="{{ asset('staradmin/vendors/css/vendor.bundle.addons.css') }}">
	<!-- endinject -->
	<!-- plugin css for this page -->
	<!-- End plugin css for this page -->
	<!-- inject:css -->
	<link rel="stylesheet" href="{{ asset('staradmin/css/style.css') }} ">
	<!-- endinject -->
	<link rel="shortcut icon" href="{{ asset('staradmin/images/favicon.png') }}"/>
</head>

<body>
	<div class="container-scroller">
		<div class="container-fluid page-body-wrapper full-page-wrapper auth-page">
			<div class="content-wrapper d-flex align-items-center auth auth-bg-1 theme-one">
				<div class="row w-100">
					<div class="col-lg-4 mx-auto">
						<div class="auto-form-wrapper">
							<form method="post" action="{{route('memberlogin.submit')}}">

								{{ csrf_field() }} 
								@foreach ($errors->all() as $error)
								<div class="alert alert-danger" role="alert">@lang($error)</div>
								@endforeach


								<div class="form-group">
									<label class="label">@lang('dingsu.username')</label>
									<div class="input-group">
										<input type="text" class="form-control" placeholder="@lang('dingsu.username')" id="username" name="username" value="{{ old('username') }}" autofocus>
										<div class="input-group-append">

											<span class="input-group-text">
                        <i class="mdi mdi-check-circle-outline"></i>
                      </span>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="label">@lang('dingsu.password')</label>
									<div class="input-group">
										<input type="password" class="form-control" placeholder="*********" id="password" name="password">
										<div class="input-group-append">
											<span class="input-group-text">
                        <i class="mdi mdi-check-circle-outline"></i>
                      </span>
										

										</div>
									</div>
								</div>
								<div class="form-group">
									<button class="btn btn-primary submit-btn btn-block">@lang('dingsu.login')</button>
								</div>
								<div class="form-group d-flex justify-content-between">
									<div class="form-check form-check-flat mt-0">
										<label class="form-check-label">
                     						
											
					<input type="checkbox" class="form-check-input" name="remember" {{ old('remember') ? 'checked' : '' }}> @lang('dingsu.remember_me')
                    						
                    </label>


									

									</div>
									<a href="{{route('member.reset.password')}}" class="text-small forgot-password text-black">@lang('dingsu.forget_password')</a>
								</div>


							</form>
						</div>
						<p></p>
						<p class="footer-text text-center">@lang('dingsu.copyright') © 2018 @lang('dingsu.company_name'). @lang('dingsu.all_rights_reserved').</p>
					</div>
				</div>
			</div>
			<!-- content-wrapper ends -->
		</div>
		<!-- page-body-wrapper ends -->
	</div>
	<!-- container-scroller -->
	<!-- plugins:js -->
	<script src="{{ asset('staradmin/vendors/js/vendor.bundle.base.js') }} "></script>
	<script src="{{ asset('staradmin/vendors/js/vendor.bundle.addons.js') }}"></script>
	<!-- endinject -->
	<!-- inject:js -->
	<script src="{{ asset('staradmin/js/off-canvas.js') }}"></script>
	<script src="{{ asset('staradmin/js/hoverable-collapse.js') }}"></script>
	<script src="{{ asset('staradmin/js/misc.js') }}"></script>
	<script src="{{ asset('staradmin/js/settings.js') }}"></script>
	<script src="{{ asset('staradmin/js/todolist.js') }}"></script>
	<!-- endinject -->
</body>

</html>