@extends('layouts.app')

@section('title', trans('dingsu.login'))

@section('top-css')
    @parent
	<link rel="stylesheet" href="{{ asset('/client/css/register.css') }}" />
@endsection

@section('content')
<div class="wrapper full-height">
	<form method="post" action="{{route('memberlogin.submit')}}">
	<div class="row">
		<div class="card">
			
			{{ csrf_field() }} 
			@foreach ($errors->all() as $error)
			<div class="alert alert-danger" role="alert">@lang($error)</div>
			@endforeach

			<div class="input-group">				
				<span class="input-group-addon"><i class="fa fa-phone"></i></span>
				<input type="text" placeholder="@lang('dingsu.ph_mobile_no')" id="phone" name="phone" value="{{ old('phone') }}" autofocus>
			</div>
						
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-lock"></i></span>
				<input type="password" placeholder="*********" id="password" name="password">
			</div>
		</div>
	</div>
	
    <div class="row">
		<div class="card">
			<div class="text left">{{trans('dingsu.info_forgot_password')}}</div>
		</div>
	</div>

	<div class="row">
        <div class="card">
					
			<button class="btn  btn-rectangle">@lang('dingsu.login')</button>
        </div>
	</div>
	</form>	
</div>
@endsection