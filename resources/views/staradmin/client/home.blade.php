@extends('layouts.layout')

@section('title', '阿福街')

@section('top-css')
    @parent
	<link rel="stylesheet" href="{{ asset('/client/css/home.css') }}" />
@endsection


@section('content')	
		<!-- Static navbar -->
		<div id="header">
			<nav class="navbar navbar-default">
			  <div class="container-fluid">
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="col-xs-3">
					<div class="div-icon left">
						@if (isset(Auth::Guard('member')->user()->username))
						<a href="#"><i class="fas fa-user"></i> {{ Auth::Guard('member')->user()->username }}</a>
						@else
					  	<a href="/register"><i class="fas fa-user-plus"></i>注册</a>
					  	@endif
					</div>
				</div>
				
				<div class="col-xs-6 div-brand">
					  <a class="navbar-brand" href="#">
						<img src="/client/images/logo.jpg" alt="logo" class="logo" />
					  </a>
				</div>
			
				<div class="col-xs-3">
					<div class="div-icon right">
					  <a href="#"><i class="fas fa-rss"></i>关注</a>
					</div>
				</div>
			  </div>
			  <!-- /.container-fluid -->
			</nav>
		<!-- End Static navbar -->
			
		<!-- Collect the nav links, forms, and other content for toggling -->
		@if(isset($category))
		<div class="category-bar navbar">
			
			@foreach($category as $cat)
			
			<a href="/cs/{{$cat->id}}" class="hvr-underline-from-center">{{$cat->display_name}}</a>
			
			
			
			@endforeach
		</div>
		@endif

		</div>
		
        <div class="wrapper banner-bg">
			<img src="/client/images/banner.jpg" alt="banner" class="banner" />
        </div>
		
		<div class="wrapper full-height">
			<div class="card">
				<div class="title">拉新人的奖励<div class="button-wrapper"><button class="btn_recommend">每推荐好友增加3次机会</button></div></div>
			</div>
			
		
			<div class="prize-wrapper">
				<div class="prize-container">
					<div class="prize-title">闯关夺宝</div>
					<div class="prize-description">拉一名新人获得3次机会</div>
					<div class="prize-row">
						<div class="prize-box">
							<div class="prize-number">20<div class="prize-label">¥</div></div>
							<div class="prize-label">话费直充</div>
							<div class="prize-info">闯一关领取</div>
						</div>
						<div class="prize-box">
							<div class="prize-number">40<div class="prize-label">¥</div></div>
							<div class="prize-label">话费直充</div>
							<div class="prize-info">闯两关领取</div>
						</div>
						<div class="prize-box">
							<div class="prize-number">100<div class="prize-label">¥</div></div>
							<div class="prize-label">天猫购物卡</div>
							<div class="prize-info">闯三关领取</div>
						</div>
					</div>
					<div class="prize-row">
						<div class="prize-box">
							<div class="prize-number">200<div class="prize-label">¥</div></div>
							<div class="prize-label">天猫购物卡</div>
							<div class="prize-info">闯三关领取</div>
						</div>
						<div class="prize-box">
							<div class="prize-number">400<div class="prize-label">¥</div></div>
							<div class="prize-label">天猫购物卡</div>
							<div class="prize-info">闯三关领取</div>
						</div>
						<div class="prize-box">
							<div class="prize-number">1000<div class="prize-label">¥</div></div>
							<div class="prize-label">天猫购物卡</div>
							<div class="prize-info">闯三关领取</div>
						</div>
					</div>
					<div class="prize-row">
						<a href="/arcade" class="btn btn-rectangle">
							进入闯关
						</a>
					</div>
				</div>
			</div>
			
			
			
			<div class="card">
				<div class="title">超值试用<div class="button-wrapper"><button class="btn_recommend">每天10点更新</button></div></div>
			</div>
			
			<div class="listing">
				
			@if(isset($vouchers))
			<div class="infinite-scroll">
			@foreach($vouchers as $item)
				
				<div class="row">
					<div class="col-xs-4">
						<img class="product" src="{{$item->product_picurl}}" alt="{{$item->product_name}}">
					</div>
					<div class="col-xs-8">
						<div class="description">{{$item->product_name}}</div>
						<div class="price">¥ {{$item->product_price}}</div>
						<div class="col-xs-6 promo-price">试用价19.9元</div>
						<div class="col-xs-5 view">已有15人申请</div>
					</div>
				</div>
				@endforeach
				
				{{ $vouchers->links() }}
			</div>
			@endif
				
				
				
			</div>
		</div>
<br><br>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="//unpkg.com/jscroll/dist/jquery.jscroll.min.js"></script>

<script type="text/javascript">
        $('ul.pagination').hide();
	
	 
        $('.infinite-scroll').jscroll({
            autoTrigger: true,
            debug: true,
            loadingHtml: '<img class="center-block" src=" {{ asset('/client/images/ajax-loader.gif') }} " alt="Loading..." />',
            padding: 0,
            nextSelector: '.pagination li.active + li a',
            contentSelector: '.infinite-scroll',
            callback: function() {
                $('ul.pagination').remove();
            }
        });
    
	
    </script>
@endsection
