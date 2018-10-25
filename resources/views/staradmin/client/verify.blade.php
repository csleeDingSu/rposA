@extends('layouts.default')

@section('title', '个人主页')

@section('top-css')
    @parent
	<link rel="stylesheet" href="{{ asset('/client/css/verify.css') }}" />
@endsection

@section('content')
<div class="full-height">
	<div class="container">
		<!-- member id -->
		<div class="card">
			<div class="icon-verify-wrapper">
				<div class="icon-verify"></div>
			</div>
			<div class="instructions">
				您需要通过实名认证
				<br />
				才能享受网站的福利
			</div>
			<div class="btn-verify">
				<a href="/validate">
					<div class="left">马上去认证</div>
					<div class="glyphicon glyphicon-menu-right"></div>
				</a>
			</div>			
		</div>
		<div class="btn-close">
			<a href="/">
				<div class="glyphicon glyphicon-remove-circle"></div>
				<div class="left"> 暂时不想认证，先逛逛看。</div>
			</a>
		</div>
		<!-- end member id -->
	</div>
</div>

@endsection
