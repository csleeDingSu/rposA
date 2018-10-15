@extends('layouts.app')

@section('title', '闯关猜猜猜')

@section('top-css')
    @parent

    <link rel="stylesheet" href="{{ asset('/client/css/game.css') }}" />
    <link rel="stylesheet" href="{{ asset('/client/css/swiper.css') }}" />
@endsection
    	
@section('content')	
<div class="full-height">
	<!-- information table -->
	<div class="information-table">
		<div class="grid-container">
			<div class="box">
				<div class="coin"></div>
				<div class="number long">
					<span class="balance" id="spanPoint">0</span>
					<div class="info-wrapper">
						<div class="info">换钱</div>
					</div>
				</div>
			</div>
			<div class="box">
				<div class="right">
					<div class="drumstick"></div>
					<div class="number">
						<span class="balance" id="divBalance">0</span>
					</div>
				</div>
			</div>
			<div class="box">
				<div class="rules"><span class="rules-label">规则介绍</span></div>
			</div>
			<input id="hidBalance" type="hidden" value="" />
			<input id="hidLevel" type="hidden" value="" />
			<input id="hidLevelId" type="hidden" value="" />
			<input id="hidLatestResult" type="hidden" value="" />
			<input id="hidUserId" type="hidden" value="{{isset(Auth::Guard('member')->user()->id) ? Auth::Guard('member')->user()->id : 0}}" />
	  	</div>
	</div>
	<!-- end information table -->

	<!-- swiper iframe -->
	<div class="swiper-container">
		<div class="swiper-wrapper">
			<div class="swiper-slide">
				<iframe id="ifm_result" class="embed-responsive-item" src="/results" allowtransparency="true" frameBorder="0" scrolling="no" align="middle">
			</iframe>
			</div>
			<div class="swiper-slide">
				<iframe id="ifm_wheel" class="embed-responsive-item" src="/wheel" allowtransparency="true" frameBorder="0" scrolling="no">
			</iframe>
			</div>
			<div class="swiper-slide">
				<iframe id="ifm_history" class="embed-responsive-item" src="/history" allowtransparency="true" frameBorder="0" scrolling="no">
			</iframe>
			</div>
		</div>

		<div class="swiper-button-next"></div>
		<div class="swiper-button-prev"></div>
	</div>
	<!-- end swiper iframe -->

	<!-- progress bar -->
	<div class="progress-bar-container">
    	<div class="progress-bar">
    		<span class="speech-bubble level-one hide">消耗10鸡腿，能挖到10鸡腿加10金币。</span>
    		<div class="circle">
    			<span class="label">x</span>
    			<div class="title">10</div>
            </div>
            <span class="bar-short"></span>
            <span class="speech-bubble level-two hide">消耗30鸡腿，能挖到40鸡腿加20金币。</span>
            <div class="circle">
            	<span class="label">x</span>
                <div class="title">30</div>
            </div>
            <span class="bar"></span>
            <span class="speech-bubble level-three hide">消耗70鸡腿，能挖到110鸡腿加30金币。</span>
            <div class="circle ">
            	<span class="label">x</span>
                <div class="title">70</div>
            </div>
            <span class="bar"></span>
            <span class="speech-bubble level-four hide">消耗150鸡腿，能挖到260鸡腿加40金币。</span>
            <div class="circle">
            	<span class="label">x</span>
                <div class="title">150</div>
            </div>
            <span class="bar-long"></span>
            <span class="speech-bubble level-five hide">消耗310鸡腿，能挖到570鸡腿加50金币。</span>
            <div class="circle">
            	<span class="label">x</span>
                <div class="title">310</div>
            </div>
            <span class="bar"></span>
            <span class="speech-bubble level-six hide">消耗630鸡腿，能挖到1200鸡腿加60金币。</span>
            <div class="circle">
            	<span class="label">x</span>
                <div class="title">630</div>
            </div>
    	</div>
	</div>
	<!-- end progress bar -->

	<!-- button wrapper -->
	<div class="button-wrapper">
        <div class="button-card radio-primary">
        	<div class="radio btn-rectangle">
				<input name="rdbBet" class="invisible" type="radio" value="odd">单数
				<div class="bet-container">0</div>
			</div>
		  </div>
		  <div class="button-card radio-primary right">
			<div class="radio btn-rectangle">
				<input name="rdbBet" class="invisible" type="radio" value="even">双数
				<div class="bet-container">0</div>
			</div>
		  </div>
	</div>
	<!-- end button wrapper -->
</div>
@endsection

@section('footer-javascript')
	@parent
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.countdown/2.2.0/jquery.countdown.min.js"></script>
	<script src="{{ asset('/client/js/swiper.min.js') }}"></script>
	<script src="{{ asset('/client/js/game.js') }}"></script>
	
@endsection