@section('top-css')
    @parent
    <link rel="stylesheet" href="{{ asset('/client/css/game-ranking.css') }}" />
    
@endsection
@section('top-javascript')
	@parent
	<script src="{{ asset('/client/js/game-ranking.js') }}"></script>
	
@endsection

<div class="bgColor">
<!-- ranking start-->
<div class="redeem-banner">
	<img src="{{ asset('/client/images/ranking/banner-title-ranking.png') }}" alt="share">
</div>
<div class="ranking-note-top">
	<div class="description">
        每1场抽奖补贴最多可获得12元，补贴可提现到支付宝，邀请好友能获得大量的补贴场次，从此购物全补贴，买买买不心疼。
	</div>
	<!-- <div class="highlight">每次抽奖补贴有98.43%概率获得12元。</div> -->
</div>
<div class="ranking-note-bottom">
	<div class="total-point-left">
		<p>你累计获得补贴（元）</p>
		<p class="my-earning-point">{{$earnedpoint}}</p>
	</div>
	<div class="total-point-right">
		<p>成功邀请好友</p>
		<p class="my-invitation-count">{{ $total_intro }}</p>
		<a href="/pre-share">
			<img class="icon-invite" src="{{ asset('/client/images/ranking/icon-invite.png') }}" />
		</a>
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
                    	<img class="icon-good-friends" src="{{ asset('/client/images/ranking/good-friends.png') }}" />好友排名                    	
                    </div>
                </a>                        
            </li>          
        </ul>
    </div>
    <div class="row tab-remark-1"><div class="col">排名数据实时更新</div></div>    	
	<div class="row tab-row-header">
		<div class="col-1 tab-col-header">排名</div>
		<div class="col-5 tab-col-header-name">名称</div>
		<div class="col-3 tab-col-header">总收益（元）</div>
	</div>
	<div class="row tab-content-my-ranking" id="my-ranking"></div>
    <div class="tab-content">
        <div id="general-ranking" class="tab-pane fade in active">
            <div id="general-list" class="tab-pane fade in active"></div>
        </div>

        <div id="my-friend-ranking" class="tab-pane fade">
	        <div id="my-friend-list" class="tab-pane fade in active"></div>                    
        </div>
    </div>
    <div class="tab-content-bottom"></div>
</div>
<!-- ranking end-->
</div>
