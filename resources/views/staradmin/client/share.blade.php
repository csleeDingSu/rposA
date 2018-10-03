@extends('layouts.app')

@section('title', '闯关猜猜猜')

@section('top-css')
    @parent
	<link rel="stylesheet" href="{{ asset('/client/css/share.css') }}" />
@endsection

@section('content')
<div class="wrapper full-height">
    <div class="row">
		<div class="card">
			<div class="text-wrapper">
				<div class="margin">&nbsp;</div>
				<div class="title">每拉</div>
				<div class="text-one"></div>
				<div class="title">位新人&nbsp;&nbsp;得</div>
				<div class="text-three"></div>
				<div class="title">闯关机会</div>		
			</div>
			<div class="clear"></div>		
			<div class="numbers">最高获得3000元奖品</div>			
		</div>
	</div>
	
	<div class="prize-wrapper">
		<div class="prize-container"></div>
	</div>
	
	<div class="button-wrapper">
        <div class="button-card">
			<a href="#" class="btn btn-rectangle"></a>
        </div>
	</div>
	
	<div class="row">
		<div class="card">
			<div class="text-wrapper">
				<div class="icon-check"></div>
				<div class="text-check">查看闯关规则和奖品</div>			
			</div>
		</div>
	</div>
	
	<div class="information-table">
		<div class="row headers">
			<div class="col-xs-6 info">奖励详情</div>
			<div class="col-xs-6 details">奖励明细 ></div>
		</div>
		<div class="row body">
			<div class="col-xs-3 balance">
				<div class="large-font">9次</div>
				<div class="count">可用次数</div>
			</div>
			<div class="col-xs-3">
				<div><span class="large-font">3</span><span class="normal-font">次</span></div>
				<div class="count">已获次数</div>
			</div>
			<div class="col-xs-3">
				<div><span class="large-font">6</span><span class="normal-font">次</span></div>
				<div class="count">待确认次数</div>
			</div>
			<div class="col-xs-3">
				<div><span class="large-font">9</span><span class="normal-font">次</span></div>
				<div class="count">已用次数</div>
			</div>
		</div>
	</div>
</div>
@endsection