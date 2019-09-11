@section('top-css')
    @parent
    <link rel="stylesheet" href="{{ asset('/client/css/game-ranking-vip.css') }}" />

@endsection
<div class="bgColor">
<!-- ranking start-->
<div class="redeem-banner">
	<img src="{{ asset('/client/images/ranking/banner-title-ranking-vip.png') }}" alt="share">
</div>
<div class="ranking-note-top">
	<div class="description">
			自助抽奖换金币，奖品任你换不停
	</div>
	<div class="note">
		<img class="icon-note" src="{{ asset('/client/images/ranking/icon-draw.png') }}" />
		<span class="highlight">无限极抽奖，</span>
		任你抽到爽
	</div>
	<div class="note">
		<img class="icon-note" src="{{ asset('/client/images/ranking/icon-reward.png') }}" />
		<span class="highlight">卡券奖品，</span>
		拿到手软
	</div>
	<div class="note">
		<img class="icon-note" src="{{ asset('/client/images/ranking/icon-random.png') }}" />
		<span class="highlight">100%随机，</span>
		绝无作弊
	</div>
</div>
<div class="ranking-note-bottom">
	<div class="total-point-left">
		<p>你累计赚得金币</p>
		<p class="my-earning-point">0.00</p>
	</div>
	<div class="total-point-right">
		<p>已换购金币</p>
		<p class="my-invitation-count">0</p>
	</div>
</div>
<div class="ranking">
	<div class="full-width-tabs">
        <ul class="nav nav-pills">
            <li class="take-all-space-you-can active">
                <a class="tab" data-toggle="tab" href="#general-ranking" data-status="general-ranking" id="general">
                    <div class="lbl-general-ranking">
                    	<img class="icon-trophy" src="{{ asset('/client/images/ranking/trophy-over.png') }}" />总排名
                    </div>
                </a>                        
            </li>              
        
            <li class="take-all-space-you-can">
                <a class="tab" data-toggle="tab" href="#my-friend-ranking" data-status="my-friend-ranking" id ="my-friend">
                    <div class="lbl-my-friend-ranking">
                    	<img class="icon-good-friends" src="{{ asset('/client/images/ranking/good-friends.png') }}" />换购名单                    	
                    </div>
                </a>                        
            </li>          
        </ul>
    </div>
    <div class="row tab-remark-1"><div class="col">换购名单实时更新</div></div>
    <div class="tab-content">
        <div id="general-ranking" class="tab-pane fade in active">
        	<div class="row tab-row-header">
				<div class="col-1 tab-col-header">排名</div>
				<div class="col-5 tab-col-header-name">名称</div>
				<div class="col-3 tab-col-header">总收益（元）</div>
			</div>
			<div class="row tab-content-my-ranking">
				<div class="col-1 ranking-number">123</div>
				<div class="col-5 ranking-name">super man 999</div>
				<div class="col-3 ranking-point">100</div>
			</div>
            <div id="general-list" class="tab-pane fade in active">
            </div>
        </div>

        <div id="my-friend-ranking" class="tab-pane fade">
	        <div id="my-friend-list" class="tab-pane fade in active">
	            <div class="tab-content-list">
            		<div class="line-1">
						<span class="ranking-phone-number">122****2563</span>
						<span class="ranking-date">2019-01-01 13:13</span>
					</div>
					<div class="line-2">
						<!-- <span class="ranking-product"><span class="highlight">换购</span> Beats EP </span> -->
						<span class="ranking-price"><img class="icon-coin-ranking" src="{{ asset('/client/images/ranking/icon-coin.png') }}" />800</span>
					</div>
				</div>
				<div class="tab-content-list">
            		<div class="line-1">
						<span class="ranking-phone-number">122****2563</span>
						<span class="ranking-date">2019-01-01 13:13</span>
					</div>
					<div class="line-2">
						<span class="ranking-product"><span class="highlight">换购</span> Beats EP </span>
						<span class="ranking-price"><img class="icon-coin-ranking" src="{{ asset('/client/images/ranking/icon-coin.png') }}" />800</span>
					</div>
				</div>
				<div class="tab-content-list">
            		<div class="line-1">
						<span class="ranking-phone-number">122****2563</span>
						<span class="ranking-date">2019-01-01 13:13</span>
					</div>
					<div class="line-2">
						<!-- <span class="ranking-product"><span class="highlight">换购</span> Beats EP </span> -->
						<span class="ranking-price"><img class="icon-coin-ranking" src="{{ asset('/client/images/ranking/icon-coin.png') }}" />800</span>
					</div>
				</div>
				<div class="tab-content-list">
            		<div class="line-1">
						<span class="ranking-phone-number">122****2563</span>
						<span class="ranking-date">2019-01-01 13:13</span>
					</div>
					<div class="line-2">
						<!-- <span class="ranking-product"><span class="highlight">换购</span> Beats EP </span> -->
						<span class="ranking-price"><img class="icon-coin-ranking" src="{{ asset('/client/images/ranking/icon-coin.png') }}" />800</span>
					</div>
				</div>
	        </div>                    
        </div>
    </div>
    <div class="tab-content-bottom"></div>
</div>
<!-- ranking end-->
</div>
@section('footer-javascript')
	@parent
	<script src="{{ asset('/client/js/game-ranking-vip.js') }}"></script>
	
@endsection
