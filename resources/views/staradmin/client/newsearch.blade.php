<!DOCTYPE HTML>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
	<meta name="format-detection" content="telephone=no" />
	<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
	<meta http-equiv="Pragma" content="no-cache" />
	<meta http-equiv="Expires" content="0" />
	<title>@lang('dingsu.home')</title>
	<link rel="stylesheet" href="{{ asset('/client/fontawesome-free-5.5.0-web/css/all.css') }}" >
	<link rel="stylesheet" href="{{ asset('/client/bootstrap-3.3.7-dist/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('/test/main/css/public.css') }}" />
	<link rel="stylesheet" href="{{ asset('/test/main/css/module.css') }}" />
	<link rel="stylesheet" href="{{ asset('/test/main/css/style.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('auth/css/module.css') }}"/>
	
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css" integrity="sha256-UK1EiopXIL+KVhfbFa8xrmAWPeBjMVdvYMYkTAEv/HI=" crossorigin="anonymous" />
	<link rel="stylesheet" href="{{ asset('/client/css/slick-theme.css') }}" />
	<link type="text/css" rel="stylesheet" href="{{ asset('/client/css/search.css') }}">

	<script type="text/javascript" src="{{ asset('/test/main/js/jquery-1.9.1.js') }}" ></script>
	<script type="text/javascript" src="{{ asset('/client/bootstrap-3.3.7-dist/js/bootstrap.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/test/main/js/being.js') }}" ></script>

	<script type="text/javascript">
    //这里是微信和qq遮罩提示层
    function isPIA(){
        var u = navigator.userAgent, app = navigator.appVersion;
        var isAndroid = u.indexOf('Android') > -1 || u.indexOf('Linux') > -1; //android终端或者uc浏览器
        var isiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端
        if(isiOS) {return 1;}
        if(isAndroid) {return 2};
    }
    var bg;
    if (isPIA() == 1) {
        bg = window.location.origin + "/vwechat/images/ios_wx.jpg";
    }else if (isPIA() == 2) {
        bg = window.location.origin + "/vwechat/images/android_wx.jpg";
    }
    // document.writeln("<div id=\"weixinTips\" style=\"display:none;background:rgba(255, 255, 255,1);width:100%;height:100%;position:fixed;left:0;top:0;z-index:9999\"><div id=\"weixinTipsImg\" style=\"background:url("+bg+") top center no-repeat;background-size:100%;width:100%;height:100%\"><\/div><\/div>");
    var ua = navigator.userAgent.toLowerCase();
    //alert(ua);
    function checkDownload() {
        if (ua.indexOf("micromessenger") > -1 || ua.indexOf("qq/") > -1) {
            document.writeln("<div id=\"weixinTips\" style=\"display:block;background:rgba(255, 255, 255,1);width:100%;height:100%;position:fixed;left:0;top:0;z-index:9999\"><div id=\"weixinTipsImg\" style=\"background:url("+bg+") top center no-repeat;background-size:100%;width:100%;height:100%\"><\/div><\/div>");

            // document.getElementById("weixinTips").style.display = "block";
            document.title="请在浏览器中打开...";
            // return false;
        }else{

        	var wabao666_domain = "<?php Print(env('wabao666_domain', 'www.wabao666.com'));?>";
            var sCurrentPathName = window.location.pathname;
            var sNewPathName = sCurrentPathName; //sCurrentPathName.replace("vvregister", "register");
            if (window.location.hostname != wabao666_domain) {
            	window.location.href = window.location.protocol + "//" + wabao666_domain + sNewPathName;	
            }
            // window.location.href = "https://www.wabao666.com" + sNewPathName;
            // var href_ = "https://www.wabao666.com" + sNewPathName;

        }

    }
    checkDownload();
</script>
<script type="text/javascript" src="//js.users.51.la/19985793.js"></script>
</head>

<body style="background:#ffffff">
<input type="hidden" id="page" value="1" />
@if(is_array($vouchers) and count($vouchers))
<input type="hidden" id="max_page" value="1" />
@else
<input type="hidden" id="max_page" value="0" />
@endif

	<section class="cardFull card-flex">
		<div class="cardHeader">
			<div class="header">
				<form id="historyForm" action="" method="GET">
				<div class="btn-back">
                	<a href="/"><img src="{{ asset('/client/images/search/left.png') }}" /></a>
                </div>
				<ul class="dbox top">			
					<li class="dbox0">
		                <div class="inBox">
                            <div class="flexSp">
                                <input type="text" class="history-input" id="strSearch" name="strSearch" placeholder="搜索商品名称：如剃须刀、T恤" required maxlength="100" value="{{ $strSearch }}" autofocus>
                                <input type="submit" id="btn_search" value="搜索" style="color: #f65e7e; font-size: 0.35rem;" />
                            
                            </div>

		                </div>
						
					</li>					
				</ul>
				</form>
				<div class="full-width-tabs">
					<ul id="search-tabs" class="nav nav-pills">
					  <li class="take-all-space-you-can active"><a class="tab" data-toggle="tab" href="#search-external">搜全网</a></li>
					  <li class="take-all-space-you-can"><a class="left tab" data-toggle="tab" href="#search-internal">搜平台卷</a></li>
					</ul>
				</div>
			</div>
			<div class="top-background">
				<img src="{{ asset('/client/images/search/bg.png') }}" />
			</div>
		</div>
		

		<div class="cardBody">
		<div class="tab-content">
				<!-- redeem list content -->
				<div id="search-external" class="tab-pane fade in active">
					
						<div class="box">
							<div class="div-instruction" {{ empty($strSearch) ? '' : 'style=display:none' }} >
								<div class="external-title">
									搜索方法
								</div>
								<ul class="instruction-list">
									<li><span class="list-style">1</span>打开手机淘宝/天猫，长按商品标题“拷贝”</li>
									<li>
										<div class="instruction-background left-border">
											<img src="{{ asset('/client/images/search/copy.png') }}" />
										</div>
									</li>
									<li><span class="list-style">2</span>进入平台点击搜索框，粘贴商品标题搜索</li>
									<li>
										<div class="instruction-background">
											<img src="{{ asset('/client/images/search/paste.png') }}" />
										</div>
									</li>
								</ul>
								<div class="external-description">
									“搜全网”功能中的商品信息均来自于互联网<br />
									商品准确信息请与商品所属店铺经营者沟通确认
								</div>
							</div>

							<div class="product">					
								<div class="infinite-scroll">
									<ul class="list-2">
											@include('client.searchajaxhome')
									</ul>
									
									
									<p class="isnext">下拉显示更多...</p>
								</div>
								
							</div>
						</div>
						
					
				</div>


				<!-- end redeem list content -->

				<!-- redeem history content -->
				<div id="search-internal" class="tab-pane fade">
						<div class="box">
							<div class="div-instruction" {{ empty($strSearch) ? '' : 'style=display:none' }}>
								<div id="div-history"></div>
								<ul class="search-list">热门搜索
									<li>
										<a href="/newsearch/洗发水"><div class="search-title">洗发水</div></a>
										<a href="/newsearch/情趣用品"><div class="search-title">情趣用品</div></a>
										<a href="/newsearch/方塞喷雾"><div class="search-title">方塞喷雾</div></a>
									</li>
									<li>
										<a href="/newsearch/情趣用品"><div class="search-title">情趣用品</div></a>
										<a href="/newsearch/情趣用品"><div class="search-title">情趣用品</div></a>
										<a href="/newsearch/内衣"><div class="search-title">内衣</div></a>
									</li>
								</ul>
								<ul class="search-list">商品分类
									@if(isset($category))
										@php @$counter = 0 @endphp
										@foreach($category as $cat)
											@php @$counter++ @endphp
											@if($counter % 4 == 1)
												<li>
											@endif
												<a href="/cs/{{$cat->id}}"><div class="search-title">{{$cat->display_name}}</div></a>
											@if($counter % 4 == 0)
												</li>
											@endif
										@endforeach
									@endif
								</ul>
							</div>

							<div class="product">					
								<div class="infinite-scroll">
									<ul class="list-2">						
											@include('client.searchajaxhome')
									</ul>
									
									
									<p class="isnext">下拉显示更多...</p>
								</div>								
							</div>
						</div>
				</div>
				<!-- end redeem list content -->
			</div>
		</div>
		
		@include('layouts/footer')

		<!-- 领取优惠券  -->
		<div class="showQuan dflex scaleHide">
			<div class="inBox">
				<img id="showIcon" src="{{ asset('/test/main/images/showIcon.png') }}" class="icon">
				<h2>点击下面复制按钮，打开淘宝APP领券</h2>

				
					<!-- <h3 id="cut" class="copyvoucher">￥K8454DFGH45H</h3> -->
					<a class="cutBtn">一键复制</a>
					<h4>优惠券代码 <span id="cut" class="copyvoucher">￥K8454DFGH45H</span></h4>
				
				
			</div>
		</div>

		<div class="showBao dflex scaleHide">
			<div class="inBox">
				<div class="imgBox">
					<img id="product_img" src="{{ asset('/test/main/images/demo/d-img3.png') }}">
				</div>
				<h2 style="white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis ;" id = 'product_name'>INS网红手表时尚潮流手表女士韩版 抖音时来运转石英表休闲</h2>
				<h3 style="display: none">
					<font id="product_discount_price">优惠价：39元</font><em id = "product_price">淘宝原价：￥360</em>
				</h3>

				<div class="group">
				 	<img src="{{ asset('/test/main/images/icon-2.png') }}" />
					<span><em id = 'voucher_price'>390金币 免费兑换</em></span>
				</div>

				<div class="group" style="text-align: center;">
					<div class="balance">你当前拥有 <em id='current_point'> {{ isset($member_mainledger->current_point) ? number_format($member_mainledger->current_point, 0, ".", "") : 0 }}</em> 金币</div>
				</div>

				<a class="btn" href="/arcade"><img src="{{ asset('/test/main/images/wabao.png') }}"></a>
				<a class="btn" href="/redeem"><div class="btn-redeem">兑换商品</div></a>

			</div>
		</div>

		<div class="showTips dflex scaleHide" id="promotion">
			<div class="inBox">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-body">				
						<div class="modal-row">
							<div class="wrapper modal-full-height">
								<div class="modal-card">
									<!-- <div class="instructions">
										<h2>0元购物攻略</h2>
										玩猜单双游戏，赢金币换<span class="highlight">购物补助金<br />
										（可提现到支付宝）</span>再去购买商品，<br />
										<span class="highlight">补助金最少30元</span>起，任你领不停。<br />
									</div> -->
									<div class="instructions" style="padding:10px 11px 10px 11px !important;">	
										<span style="font-weight: bold;">
											到<img src="{{ asset('/client/images/small-wheel.png') }}" width="15" height="15" /><span class="highlight">{{env('game_name', '幸运转盘')}}</span>赚金币换免单红包
										</span>
										<ul style="color: #a8adaa;">
											<li> • 新人100%中大额红包</li>
											<li> • 30元、50元、100元任你领</li> 
											<li> • 分享越多 转盘次数许多</li>
										</ul>
										<span style="font-weight: bold;">
											免单红包拿到手软，<span class="highlight">从此购物不花自己钱！</span>
										</span>
									</div>
									<div class="modal-label">
										<div class="icon-coin-wrapper">
											<div class="icon-coin"></div>
										</div>
										<div class="icon-label">您当前拥有
											<span class="modal-point">
											@if (isset($member_mainledger->current_point))
												{{ number_format($member_mainledger->current_point, 0, '.', '') }}
											@else
												0
											@endif
											</span>
											金币
										</div>
									</div>
									<div style="clear: both;"></div>
									<div class="modal-number">你还有
										@if (isset($member_mainledger->current_life))
											{{ number_format($member_mainledger->current_life, 0, '.', '') }}
										@else
											0
										@endif
									次游戏机会 可赚
										@if (isset($member_mainledger->current_life))
											{{ number_format($member_mainledger->current_life * 150, 0, '.', '') }}
										@else
											0
										@endif
									金币</div>
									<a href="/arcade">
										<div class="btn-wabao">去赚金币</div>
									</a>
								</div>
							</div>
						</div>							
					</div>
				</div>
			</div>
			</div>
		</div>
	</section>
	
	

	<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js" integrity="sha256-NXRS8qVcmZ3dOv3LziwznUHPegFhPZ1F/4inU7uC8h0=" crossorigin="anonymous"></script>
	<script src="{{ asset('/test/main/js/clipboard.min.js') }}" ></script>
	<script src="{{ asset('/client/js/js.cookie.js') }}"></script>
	<script src="{{ asset('/client/js/public.js') }}" ></script>
	
	<script>

		$(document).ready(function(){
			var arrHistory = Cookies.get('searchhistory');
			if(arrHistory !== undefined){
				var arrHistory = JSON.parse(arrHistory);
				var html = '<ul class="search-history">';
				html += '<li>搜索记录<img class="btn-delete" src="/client/images/search/delete.png" /></li>';

				var arrayLength = arrHistory.length;
			    for (var i = 0; i < arrayLength; i++) {
			        html += '<li><a href="/newsearch/'+ arrHistory[i] +'">'+ arrHistory[i] + '</a></li>';
			    }

			    html += '</ul>';

			    $('#div-history').html(html);
			}

			$('.btn-delete').click(function(){
				Cookies.remove('searchhistory');		

				$('#div-history').fadeOut(500, function() {
				   $(this).empty().show();
				});
			});

			

			$('.tab').click(function(){
		        $('.product').hide();
		        var object = $(this).attr('href');
		        $(object).find('.div-instruction').show();
		        
		    });

			$( "#historyForm" ).submit(function( event ) {
			  	var strSearch = $('#strSearch').val();

				if(strSearch != ''){
				  	var array = Cookies.get('searchhistory');
				  	//console.log(array);

				  	 if(array == undefined){
				  	 	var array = [];
				  	 } else {
				  	 	var array = JSON.parse(array);
				  	 }

				  	 if(!array.includes(strSearch)){
				  		array.push(strSearch);
				  	}

					array = JSON.stringify(array);

				  	Cookies.set('searchhistory', array);
				}
				window.location.href = "/newsearch/" + strSearch;
			    return false;
			});

			$('.showQuan').click((e) => {
				$('.cutBtn').removeClass('cutBtn-success').html('一键复制');
				var target = $(e.target).closest('.inBox').length;
				console.log(target);
				if (target > 0) {
					return;
				} else {
					being.scaleHide('.showQuan');
					being.wrapHide();
				}
			});

			$("body").on("click",".mset a.showvoucher",function(e) {
			//$("body").on("click",".showvoucher",function(){
				$( ".copyvoucher" ).html('please wait');		
				var dd = $(this).data('imgurl');
				$("#showIcon").attr("src",dd);
				being.wrapShow();
				being.scaleShow('.showQuan');
				$( ".copyvoucher" ).html( getpasscode( $(this).data('goodsid') ) );
			});
			
			$("body").on("click",".mset a.type",function(e) {
				being.wrapShow();
				being.scaleShow('.showTips');
			});
			
			$('.showTips').click((e) => {
				var target = $(e.target).closest('.inBox').length;
				console.log(target);
				if (target > 0) {
					return;
				} else {
					being.scaleHide('.showTips');
					being.wrapHide();
				}
			});

			$("body").on("click",".imgBox",function(){
				// item_id       = $(this).data('tt_id');
				// product_name  = $(this).data('tt_product_name');
				// product_price = $(this).data('tt_product_price');
				// product_img   = $(this).data('tt_product_img');
				// product_discount_price   = $(this).data('tt_product_discount_price');
				// voucher_price = $(this).data('tt_voucher_price');
				// showBao(item_id,product_name,product_price,product_img,product_discount_price,voucher_price);

				// being.wrapShow();
				// being.scaleShow('.showTips');
				$("#showIcon").attr("src",$(this).data('imgurl'));

				$( ".copyvoucher" ).html('please wait');
				being.wrapShow();
				being.scaleShow('.showQuan');
				$( ".copyvoucher" ).html( getpasscode( $(this).data('goodsid') ) );
			});
			
			function getpasscode( keyword ) {
				var url = "{{route('get_passcode')}}";

				$.ajax( {
					url: url,
					data: {
						_method: 'get',
						_token: "{{ csrf_token() }}",
						_keyword: keyword
					},
				} ).done( function ( data ) {
					if (data.success == 'true')
						{
							var result = data.record;
							//alert(result.passcode);
							$( ".copyvoucher" ).html( result.passcode );
							return result.passcode;
						}
					
					
				} ).fail( function () {
					alert( 'datalist could not be loaded.' );
					
				} );
			}

			function showBao(item_id,product_name,product_price,product_img,product_discount_price,voucher_price)
			{
				being.wrapShow();
				document.getElementById("product_name").textContent = product_name;
				// $(this).find("#product_name").innerHTML = product_name;
				document.getElementById("product_price").textContent = '淘宝原价：￥' + product_price;
				document.getElementById("product_discount_price").textContent = '优惠价：' + product_discount_price + '元';
				document.getElementById("product_img").src = product_img;
				document.getElementById("voucher_price").textContent = Math.round((product_price - voucher_price) * 10);

				being.scaleShow('.showBao');
			}

			$('.showBao').click((e) => {
				var target = $(e.target).closest('.inBox').length;
				console.log(target);
				if (target > 0) {
					return;
				} else {
					being.scaleHide('.showBao');
					being.wrapHide();
				}
			});

			var clipboard = new ClipboardJS('.cutBtn', {
				target: function () {
					return document.querySelector('#cut');
				}
			});
			clipboard.on('success', function (e) {
				console.log(e);
				$('.cutBtn').addClass('cutBtn-success').html('复制成功 请打开淘宝App');
			});

			clipboard.on('error', function (e) {
				console.log(e);
				$('.cutBtn').addClass('cutBtn-success').html('复制成功 请打开淘宝App');
			});

			being.scrollBottom('.cardBody', '.box', () => {

				page++;
				console.log(page);
				var max_page = parseInt($('#max_page').val());
				if(page > max_page) {
					$('#page').val(page);
					$(".isnext").html("@lang('dingsu.end_of_result')");
					$('.isnext').css('padding-bottom', '50px');

				}else{
					getPosts(page);
				}	
			});
		})

		$('ul.pagination').hide();
		
		var page=1;
		var max_page = parseInt($('#max_page').val());

		if(max_page == 0){
			$(".isnext").html("@lang('dingsu.end_of_result')");
		}
				
		function getPosts(page){
			$.ajax({
				type: "GET",
				url: window.location+"/?page"+page, 
				data: { page: page },
				beforeSend: function(){ 
				},
				complete: function(){ 
				  $('#loading').remove
				},
				success: function(responce) { 
					$('.list-2').append(responce.html);
				}
			 });
		}
		
	</script>

</body>

</html>