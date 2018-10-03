@extends('layouts.app')

@section('title', '闯关猜猜猜')

@section('top-css')
    @parent

    <link rel="stylesheet" href="{{ asset('/client/css/game.css') }}" />
    <link rel="stylesheet" href="{{ asset('/client/css/swiper.min.css') }}" />
	<style type="text/css">
		body{
			background: #000000;
			padding:0px;
			margin:0px;
		}
		
		iframe {
			width: 458px;
			height: 458px;
			margin: 0 auto;
			display:block;
		}

		.swiper-container {
	      width: 800px;
	      height: 458px;
	    }
	</style>
@endsection
    	
@section('content')	
	<div class="wrapper full-height">
		<div class="text center">
			<img src="{{ asset('/client/images/game_title.png') }}" width="500" />
		</div>

<div class="swiper-container">
    <div class="swiper-wrapper">
      <div class="swiper-slide">
      	<iframe class="embed-responsive-item" src="/history" allowtransparency="true" frameBorder="0" scrolling="no">
      	</iframe>
	  </div>
      <div class="swiper-slide">
      	<iframe class="embed-responsive-item" src="/wheel" allowtransparency="true" frameBorder="0" scrolling="no">
		</iframe>
	  </div>
      <div class="swiper-slide">
      	<iframe class="embed-responsive-item" src="/results" allowtransparency="true" frameBorder="0" scrolling="no">
		</iframe>
	  </div>
    </div>
    <!-- Add Arrows -->
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
  </div>

		<div class="text center">
			猜下一次是单数或双数
		</div>

		<!-- Profile Page Finish -->
	    	
		<div class="progress-bar-container">
        	<div class="progress-bar">
        		<span class="speech-bubble level-one">可赢20积分，纯赚10积分</span>
        		<div class="circle">
        			<span class="label">x</span>
	                <div class="title">10</div>
	            </div>
	            <span class="bar-short"></span>
	            <span class="speech-bubble level-two hide">可赢60积分，扣除前1次亏损，纯赚20积分</span>
	            <div class="circle">
	            	<span class="label">x</span>
	                <div class="title">30</div>
	            </div>
	            <span class="bar"></span>
	            <span class="speech-bubble level-three hide">可赢140积分，扣除前2次亏损，纯赚30积分</span>
	            <div class="circle ">
	            	<span class="label">x</span>
	                <div class="title">70</div>
	            </div>
	            <span class="bar"></span>
	            <span class="speech-bubble level-four hide">可赢300积分，扣除前3次亏损，纯赚40积分</span>
	            <div class="circle">
	            	<span class="label">x</span>
	                <div class="title">150</div>
	            </div>
	            <span class="bar"></span>
	            <span class="speech-bubble level-five hide">可赢620积分，扣除前4次亏损，纯赚50积分</span>
	            <div class="circle">
	            	<span class="label">x</span>
	                <div class="title">310</div>
	            </div>
	            <span class="bar"></span>
	            <span class="speech-bubble level-six hide">可赢1260积分，扣除前5次亏损，纯赚60积分</span>
	            <div class="circle">
	            	<span class="label">x</span>
	                <div class="title">630</div>
	            </div>
        	</div>
		</div>

		<div class="button-wrapper">
	        <div class="button-card radio-primary">
	        	<div class="radio btn btn-rectangle">
					<input class="invisible" type="radio" ng-model="forms.selected" ng-value="first_big" ng-click="radioCheckUncheck($event)">单数
				</div>
			  </div>
			  <div class="button-card radio-primary">
				<div class="radio btn btn-rectangle">
					<input class="invisible" type="radio" ng-model="forms.selected" ng-value="first_small" ng-click="radioCheckUncheck($event)">双数
				</div>
			  </div>
		</div>
		<div style="clear: both;"></div>

		<div class="information-table">
		<div class="row">
			<div class="col-xs-4 border-right">
				<div class="header">当前积分</div>
				<div class="number">1200</div>
			</div>
			<div class="col-xs-4 border-right">
				<div class="header">可提现红包</div>
				<div class="number">100元</div>
			</div>
			<div class="col-xs-4">
				<div class="header">剩余次数</div>
				<div class="number">1</div>
			</div>
		</div>
	</div>
	</div>
@endsection

@section('footer-javascript')
	@parent
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.countdown/2.2.0/jquery.countdown.min.js"></script>
	<script src="{{ asset('/client/js/game.js') }}"></script>
	<script src="{{ asset('/client/js/swiper.min.js') }}"></script>
	<script type="text/javascript">
	var swiper = new Swiper('.swiper-container', {
	  initialSlide: 1,
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
    });

	</script>
@endsection