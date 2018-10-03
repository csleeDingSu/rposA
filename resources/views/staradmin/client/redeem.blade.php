@extends('layouts.app')

@section('title', '兑换奖品')

@section('top-css')
    @parent
	<link rel="stylesheet" href="{{ asset('/client/css/redeem.css') }}" />
@endsection

@section('content')
<div class="wrapper full-height">
    <div class="row">
		<div class="card">
			<div class="numbers center">恭喜你闯了三关!</div>
			<div class="text center">你获得了以下奖品</div>
		</div>
	</div>
	
	<div class="row">
		<img src="/client/images/voucher.png" alt="vouchers" class="prize" />
	</div>
	
	<div class="row">
        <div class="card">
			<a href="#" class="btn btn-rectangle">
                确认兑换
            </a>
        </div>
	</div>
	
	<div class="row">
		<div class="card">
			<ol class="text">
				<li>你兑换的奖品，可在会员中心里已兑换查看。</li>
				<li>一般兑换时间为10分钟内。</li>
				<li>请保管好自己的卡密，请勿泄露。</li>
			</ol>
		</div>
	</div>
</div>
@endsection