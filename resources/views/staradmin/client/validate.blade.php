@extends('layouts.app')

@section('title', '实名认证')

@section('top-css')
    @parent
	<link rel="stylesheet" href="{{ asset('/client/css/validate.css') }}" />
@endsection

@section('content')
<div class="wrapper full-height">
    <div class="row">
		<div class="card">
			<div class="title">第一步：提交真实姓名</div>
			<div class="inputWithIcon">
				<input type="text" placeholder="请输入真实姓名" />
				<div class="name"></div>
			</div>
		</div>
	</div>
	
	<div class="row">
        <div class="card">
			<a href="#" class="btn btn-rectangle">
                提交
            </a>
        </div>
	</div>
	
	<div class="row">
		<div class="card">
			<div class="card-margin">
				<div class="title">第二步：加客服微信审核</div>
			</div>
			<img src="/client/images/validate.png" alt="validate" class="img-validate" />
		</div>
	</div>
</div>
@endsection