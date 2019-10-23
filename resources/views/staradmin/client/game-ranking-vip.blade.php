@section('top-css')
    @parent
    <link rel="stylesheet" href="{{ asset('/client/css/game-ranking-vip.css') }}" />

@endsection

<div style="clear: both"></div>

<div class="bgColor">

<div class="redeem-banner">
	<img src="{{ asset('/clientapp/images/vip-node/redeem-banner.png') }}" alt="精选奖品">
</div>

<!-- redeem price start-->
<div class="redeem-prize-wrapper"></div>
<div style="clear: both"></div>

<div class="redeem-more">
	<a href="/shop">更多兑换奖品，点击进入商城 ></a>
</div>

<!-- ranking start-->
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
                <a class="tab" data-toggle="tab" href="#buy-product-ranking" data-status="buy-product-ranking" id ="buy-product">
                    <div class="lbl-buy-product-ranking">
                    	<img class="icon-good-friends" src="{{ asset('/client/images/ranking/good-friends.png') }}" />换购名单                    	
                    </div>
                </a>                        
            </li>          
        </ul>
    </div>
    <div class="row tab-remark-1"><div class="col">排名名单实时更新</div></div>
    <div class="tab-content">
        <div id="general-ranking" class="tab-pane fade in active">
        	<div class="row tab-row-header">
				<div class="col-1 tab-col-header">排名</div>
				<div class="col-5 tab-col-header-name">名称</div>
				<div class="col-3 tab-col-header">总收益（挖宝币）</div>
			</div>
			<div class="row tab-content-my-ranking">
				<div class="col-1 ranking-number">123</div>
				<div class="col-5 ranking-name">super man 999</div>
				<div class="col-3 ranking-point">100</div>
			</div>
            <div id="general-list" class="tab-pane fade in active">
            </div>
        </div>

        <div id="buy-product-ranking" class="tab-pane fade">
	        <div id="buy-product-list" class="tab-pane fade in active">
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
