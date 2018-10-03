@extends('layouts.app')

@section('title', '登陆')

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
			
			<div class="inputWithIcon">
				<input type="text" placeholder="@lang('dingsu.username')" id="username" name="username" value="{{ old('username') }}" autofocus>
			</div>
			
			<div class="inputWithIcon">
				<input type="password" placeholder="*********" id="password" name="password">
			</div>
		</div>
	</div>
	
    <div class="row">
		<div class="card">
			<div class="text left">如忘记密码请找微信客服。</div>
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