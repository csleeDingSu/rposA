<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>@lang('dingsu.company_name')</title>
	<!-- plugins:css -->
	<link rel="stylesheet" href="{{ asset('staradmin/vendors/iconfonts/mdi/css/materialdesignicons.min.css') }} ">
	<!--<link rel="stylesheet" href="{{ asset('staradmin/vendors/css/vendor.bundle.base.css') }}">
	<link rel="stylesheet" href="{{ asset('staradmin/vendors/css/vendor.bundle.addons.css') }}">-->
	<!-- endinject -->
	<!-- plugin css for this page -->
	<!-- End plugin css for this page -->
	<!-- inject:css -->
	
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
	
	<link rel="stylesheet" href=" {{ asset('staradmin/css/style.css') }}">
	
	<link rel="stylesheet" href=" {{ asset('staradmin/css/custom.css') }}">
	
	
	
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.css">
	<!-- endinject -->
	
	
	<link rel="apple-touch-icon" sizes="144x144" href="{{ asset('staradmin/images/favicon/apple-touch-icon.png') }}">
	<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('staradmin/images/favicon/favicon-32x32.png') }}">
	<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('staradmin/images/favicon/favicon-16x16.png') }}">
	<link rel="manifest" href="{{ asset('staradmin/images/favicon/site.webmanifest') }}">
	<link rel="mask-icon" href="{{ asset('staradmin/images/favicon/safari-pinned-tab.svg') }}" color="#5bbad5">
	<meta name="msapplication-TileColor" content="#da532c">
	<meta name="theme-color" content="#ffffff">
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	
	<script type="text/javascript">
	$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
	
	</script>
	
</head>