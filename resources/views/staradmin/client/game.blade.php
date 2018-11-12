@extends('layouts.default')

@section('title', '挖宝大冒险')

@section('top-css')
    @parent

    <link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">
    <link rel="stylesheet" href="{{ asset('/client/css/game.css') }}" />
    

    <style>
    	
    	.reveal-modal {
		    /*position: relative;*/
		    margin: 0 auto;
		    top: 25%;
		}

    </style>
@endsection
    	
@section('top-navbar')
@endsection

@section('content')	
<div class="full-height">
	<!-- information table -->
	<div class="information-table">
		<div class="grid-container">
			<div class="box">
				<div class="coin"></div>
				<div class="number long">
					<span class="balance" id="spanPoint">0</span> <span class="life-balance">+</span><span class="life-balance" id="spanAcuPoint">0</span>
					<div class="info-wrapper">
						<a class="btn-redeem" href="/redeem"><div class="info">换钱</div></a>
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
				<div class="btn-rules">规则介绍</div>
			</div>
			<input id="hidBalance" type="hidden" value="" />
			<input id="hidLevel" type="hidden" value="" />
			<input id="hidLevelId" type="hidden" value="" />
			<input id="hidLatestResult" type="hidden" value="" />
			<input id="hidUserId" type="hidden" value="{{isset(Auth::Guard('member')->user()->id) ? Auth::Guard('member')->user()->id : 0}}" />
			<input id="hidWechatId" type="hidden" value="{{isset(Auth::Guard('member')->user()->wechat_verification_status) ? Auth::Guard('member')->user()->wechat_verification_status : 1}}" />
			<input id="hidWechatName" type="hidden" value="{{isset(Auth::Guard('member')->user()->wechat_name) ? Auth::Guard('member')->user()->wechat_name : null}}" />
	  	</div>
	</div>
	<!-- end information table -->

	<!-- swiper iframe -->
	<!--div class="swiper-container">
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
	</div-->

	<div class="swiper-container">
		<div class="carousel-cell">
			<iframe id="ifm_result" class="embed-responsive-item" src="/results" allowtransparency="true" frameBorder="0" scrolling="no" align="middle">
			</iframe>
		</div>

		<div class="carousel-cell">
			<iframe id="ifm_wheel" class="embed-responsive-item" src="/wheel" allowtransparency="true" frameBorder="0" scrolling="no">
			</iframe>
		</div>

		<div class="carousel-cell">
			<iframe id="ifm_history" class="embed-responsive-item" src="/history" allowtransparency="true" frameBorder="0" scrolling="no">
			</iframe>
		</div>
	</div>
	<!-- end swiper iframe -->

	<div class="instruction">猜下次幸运号是单数或双数</div>

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

<!-- Steps Modal starts -->
<form class="form-sample" name="frm-steps" id="frm-steps" action="" method="post" autocomplete="on" >
	<div class="modal fade col-md-12" id="verify-steps" tabindex="-1" role="dialog" aria-labelledby="viewvouchermodellabel" aria-hidden="true" style="background-color: grey;">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-body">				
					<div class="modal-row">
						<div class="wrapper modal-full-height">
							<div class="modal-card">
								<div class="instructions">
									只需两步实名认证
									<br />
									就能享受网站福利
								</div>								
							</div>
							<div class="row">
								<div class="col-xs-2"></div>
								<div class="col-xs-4">
									<img class="img-step" src="{{ asset('/client/images/step_01.png') }}" />
									<div class="step">第一步</div>
									<div class="step-details">
										添加微信<br />
										客服审核
									</div>
								</div>
								<div class="col-xs-4">
									<img class="img-step" src="{{ asset('/client/images/step_02.png') }}" />
									<div class="step">第二步</div>
									<div class="step-details">
										通过认证<br />
										享受福利
									</div>
								</div>
								<div class="col-xs-2"></div>
							</div>
						</div>
					</div>							
				</div>
				<div class="btn-verify-wrapper">
					<div class="btn-verify">
						<a href="#">
							<div class="left">马上去认证</div>
							<div class="glyphicon glyphicon-menu-right"></div>
						</a>
					</div>
				</div>
			</div>

			<div class="modal-card">
				<div class="btn-close">
					<a href="/">
						<div class="glyphicon glyphicon-remove-circle"></div>
						<div class="left"> 不想认证，先逛逛看。</div>
					</a>
				</div>
			</div>
		</div>
	</div>
</form> 
<!-- Steps Modal Ends -->



<!-- Verify Modal starts -->
<form action="member_update_wechatname" method="post" name="wechatform" id="wechatform">
	<div class="modal fade col-md-12" id="wechat-verify" tabindex="-1" role="dialog" aria-labelledby="viewvouchermodellabel" aria-hidden="true" style="background-color: grey;">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content modal-wechat">
				<div class="modal-body">				
					<div class="modal-row">
						<div class="wrapper modal-full-height">
							<div class="modal-card">
								@csrf

								<div class="" id="validation-errors"></div>
								<div class="wechat-title">
									实名认证审核
								</div>
								
								@include('layouts.partials.notification')
								
								<div class="modal-input">
									<input type="hidden" id="memberid", name="memberid" value="{{ Auth::Guard('member')->user()->id }}"/>
									<input name="wechat_name" id="wechat_name" type="text"  placeholder="@lang('dingsu.ph_username')" value="" required>
								</div>

								<div class="wechat-wrapper">
									<img src="{{ asset('/client/images/wabao666_qrcode.JPG') }}" />
									<div>长按图片保存到手机，在扫码相册<br />
									添加客服微信，需备注 "{{ Auth::Guard('member')->user()->username }}"</div>
								</div>						
							</div>
						</div>
					</div>							
				</div>
				<div class="btn-submit-wrapper">
					<button class="btn btn-submit">@lang('dingsu.submit')</button>
				</div>
			</div>
		</div>
		<div class="modal-card">
				<div class="btn-close">
					<a href="/">
						<div class="glyphicon glyphicon-remove-circle"></div>
						<div class="left"> 不想认证，先逛逛看。</div>
					</a>
				</div>
			</div>
	</div>
</form> 
<!-- Verify Modal Ends -->

<!-- pending verify step -->

	<div class="modal fade col-md-12" id="pending-verify-steps" tabindex="-1" role="dialog" aria-labelledby="viewvouchermodellabel" aria-hidden="true" style="background-color: grey;">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content modal-wechat">
				<div class="modal-body">				
					<div class="modal-row">
						<div class="wrapper modal-full-height">
							<div class="modal-card">
								@csrf

								<div class="" id="validation-errors"></div>
								<div class="wechat-title">
									等待认证
								</div>
								
								<div class="wechat-wrapper">
									<img src="{{ asset('/client/images/wabao666_qrcode.JPG') }}" />
									<div>长按图片保存到手机，在扫码相册<br />
									添加客服微信，需备注 "{{ Auth::Guard('member')->user()->username }}"</div>
								</div>						
							</div>
						</div>
					</div>							
				</div>
			</div>
			<div class="modal-card">
				<div class="btn-close">
					<a href="/">
						<div class="glyphicon glyphicon-remove-circle"></div>
						<div class="left"> 等待认证，先逛逛看。</div>
					</a>
				</div>
			</div>
		</div>
	</div>

<!--  end -->

<!-- Game Rules Modal -->
	<div class="modal fade col-md-12" id="game-rules" tabindex="-1" role="dialog" aria-labelledby="viewvouchermodellabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content modal-wechat">
				<div class="modal-body">				
					<div class="modal-row">
						<div class="wrapper modal-full-height">
							<div class="modal-card">
								
								<div class="rules-content">
									转盘每60秒转动一次，随机获得一个幸运号。<br />
									<br />
									玩家竞猜【单数】或【双数】，猜中即可获得奖励。<br />
									<br />
									每次挖宝机会有1200挖宝币，玩家根据系统设定的6次押宝积分去玩。<br />
									最多可赚取150挖宝币，赚取的积分能兑换奖品，150挖宝币约等于15元红包。<br />
									<br />
									如果连续6次都没猜中，代表挖宝失败，并且会清零本次挖宝所赚的挖宝币。
								</div>
													
							</div>
						</div>
					</div>							
				</div>
			</div>
		</div>
	</div>

<!--  end -->

<!-- Start Reset Life Max -->

	<div class="modal fade col-md-12" id="reset-life-max" tabindex="-1" role="dialog" aria-labelledby="viewvouchermodellabel" aria-hidden="true" style="background-color: rgba(17, 17, 17, 0.65);">
		<div class="modal-dialog modal-lg modal-packet-wrapper" role="document">
			<div class="modal-packet">
				<div class="modal-body">				
					<div class="modal-row">
						<div class="wrapper modal-full-height">
							<div class="packet-title">150 封顶</div>
							<div class="packet-note">每次挖宝最多可获得150挖宝币<br />
							您当前已经完成了
							</div>
							<div class="packet-instruction">你当前还有 
								<span class="spanLife">
									{{isset(Auth::Guard('member')->user()->current_life) ? Auth::Guard('member')->user()->current_life : 0}}
								</span> 
								次挖宝机会<br />
							你可选择 <strong>继续挖宝</strong> 或 <strong>兑换奖品</strong>
							</div>
							<div class="btn-reset-life packet-button">
								<div class="packet-button-name">继续挖宝</div>
								<div class="packet-button-note">将消耗1次挖宝机会</div>
							</div>
							<a href="/redeem" class="link-button">
								<div class="packet-button">兑换奖品</div>
							</a>
						</div>
					</div>							
				</div>
			</div>
		</div>
	</div>

<!--  end -->

<!-- Start Reset Life Share -->

	<div class="modal fade col-md-12" id="reset-life-share" tabindex="-1" role="dialog" aria-labelledby="viewvouchermodellabel" aria-hidden="true" style="background-color: rgba(17, 17, 17, 0.65);">
		<div class="modal-dialog modal-lg modal-packet-wrapper" role="document">
			<div class="modal-packet">
				<div class="modal-body">				
					<div class="modal-row">
						<div class="wrapper modal-full-height">
							<div class="packet-title">150 封顶</div>
							<div class="packet-note">每次挖宝最多可获得150挖宝币<br />
							您当前已经完成了
							</div>
							<div class="packet-instruction">你当前还有 
								<span class="spanLife">
									{{isset(Auth::Guard('member')->user()->current_life) ? Auth::Guard('member')->user()->current_life : 0}}
								</span> 
							 次挖宝机会<br />
							你可选择 <strong>邀请好友</strong> 或 <strong>兑换奖品</strong>
							</div>
							<a href="/share" class="link-button">
								<div class="packet-button">
									<div class="packet-button-name">邀请好友</div>
									<div class="packet-button-note">每邀请1名好友获得1次挖宝机会</div>
								</div>
							</a>
							<a href="/redeem" class="link-button">
								<div class="packet-button">兑换奖品</div>
							</a>
						</div>
					</div>							
				</div>
			</div>
		</div>
	</div>

<!--  end -->

<!-- Start Reset Life Lose -->

	<div class="modal fade col-md-12" id="reset-life-lose" tabindex="-1" role="dialog" aria-labelledby="viewvouchermodellabel" aria-hidden="true" style="background-color: rgba(17, 17, 17, 0.65);">
		<div class="modal-dialog modal-lg modal-packet-wrapper" role="document">
			<div class="modal-packet">
				<div class="modal-body">				
					<div class="modal-row">
						<div class="wrapper modal-full-height">
							<div class="packet-title lose">挖宝失败</div>
							<div class="packet-note">将扣除本次挖宝所赚取的 
								<span class="packet-acupoint" id="spanAcuPoint">0</span> 
							 挖宝币<br />
							别气馁，再接再厉！
							</div>
							<div class="packet-instruction">你当前还有 
								<span class="spanLife">
									{{isset(Auth::Guard('member')->user()->current_life) ? Auth::Guard('member')->user()->current_life : 0}}
								</span>
							 次挖宝机会<br />
							你可选择 <strong>继续挖宝</strong> 或 <strong>兑换奖品</strong>
							</div>
							<div class="btn-reset-life packet-button">
								<div class="packet-button-name">继续挖宝</div>
								<div class="packet-button-note">将消耗1次挖宝机会</div>
							</div>
							<a href="/redeem" class="link-button">
								<div class="packet-button">兑换奖品</div>
							</a>
						</div>
					</div>							
				</div>
			</div>
		</div>
	</div>

<!--  end -->

@endsection

@section('footer-javascript')
	@parent
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.countdown/2.2.0/jquery.countdown.min.js"></script>
	<script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>
	<script src="{{ asset('/client/js/game.js') }}"></script>
	<script type="text/javascript">
		$(document).ready(function () {
			var wechat_status = $('#hidWechatId').val();
			var wechat_name = $('#hidWechatName').val();

			$('.btn-rules').click(function(){
				$('#game-rules').modal();
			});

			if(wechat_status > 0 && wechat_name == '') {
				$('#verify-steps').modal({backdrop: 'static', keyboard: false});
			} else if(wechat_status > 0 && wechat_name != '') {
				$('#pending-verify-steps').modal({backdrop: 'static', keyboard: false});
			}

			$('.btn-verify').click(function(){
				$('#verify-steps').modal('hide');
				$('#wechat-verify').modal({backdrop: 'static', keyboard: false});
			});

			@if(Session::has('info') or Session::has('success') or Session::has('warning') or Session::has('error'))
				$('#verify-steps').modal('hide');
			    $('#wechat-verify').modal({backdrop: 'static', keyboard: false});
			@endif

		});	
	</script>
@endsection