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
                                <input type="text" class="history-input" id="strSearch" name="strSearch" placeholder="粘贴淘宝商品标题 查找优惠卷" required maxlength="100" value="{{ $strSearch }}" autofocus>
                                <img src="{{ asset('/client/images/search/clear.png') }}" id="btn_clear" value="&nbsp;" />
                                <input type="submit" id="btn_search" value="搜索" style="color: #f65e7e; font-size: 0.3rem;" />        	
                            </div>
		                </div>
						
					</li>					
				</ul>
				</form>
			</div>
			<div class="top-background"></div>
		</div>
		

		<div class="cardBody">					
			<div class="box">
				<div class="div-instruction" {{ empty($strSearch) ? '' : 'style=display:none' }} >
					<ul class="instruction-list">
						<li><span class="list-style">1</span>打开手机淘宝/天猫，长按商品标题“拷贝”</li>
						<li>
							<div class="instruction-background">
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
						
						
						<p class="isnext">
							{{ empty($strSearch) ? '' : '下拉显示更多...' }}
						</p>
					</div>
					
				</div>
			</div>
		</div>
		
		@include('layouts/footer')

		<!-- 领取优惠券  -->
		<div class="showQuan dflex scaleHide">
			<div class="inBox" style="padding-bottom: 0.2rem;">
				<img id="showIcon" src="{{ asset('/test/main/images/showIcon.png') }}" class="icon">
				<div class="AfterDiscount">
					<span class="caption1">券后￥</span>
					<span class="caption2">39</span>
				</div>
				<!-- <h2>点击下面复制按钮，打开淘宝APP领券</h2> -->

				
					<!-- <h3 id="cut" class="copyvoucher">￥K8454DFGH45H</h3> -->
					<div class="div_product_name">Product name</div>
					<div class="div_product_details">
						<span class="span_highlight">优惠券 ￥<span class="span_voucher_price"></span></span> | 淘宝价 ￥<span class="span_price"></span>
					</div>
					
					<div id="button-wrapper">
						<div class="caption_redeem_angpao">
							<span>99%拿30元红包</span>
							<img src="{{ asset('/client/images/caption_redeem_angpao.png') }}" />
						</div>
						<img class="btn-product-details" src="{{ asset('/client/images/btn-redeem.png') }}" />
						<div id="btn-copy" class="btn-copy">领取优惠券</div>
						<div id="btn-voucher" class="freeVoucherBtn"><span>玩转盘拿红包</span></div>
					</div>
					<h4 style="font-size: 0;">优惠券代码 <span id="cut" class="copyvoucher">￥K8454DFGH45H</span></h4>

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
					<div class="modal-body" style="padding:10px !important;">				
						<div class="modal-row">
							<div class="wrapper modal-full-height">
								<div class="modal-card">
									<div class="instructions">
										<ul>
											<li>
												<img src="/client/images/list-image.png" width="14px" height="18px" />
												<span class="highlight">新人红包</span>
												<img src="/client/images/list-label.png" width="42px" height="14px" /></li>
											<li style="padding-bottom: 10px">注册送2次免单转盘，每次可赚15元，2次可以赚30元。</li>
											<li>
												<img src="/client/images/list-image.png" width="14px" height="18px" />
												<span class="highlight">分享越多 赚越多</span>
												<img src="/client/images/list-label.png" png" width="42px" height="14px" /></li>
											<li>邀请好友注册送1次转盘，你邀请的好友每邀请1个人，你还能获得1次转盘。<br>如果你邀请10个好友，每个好友也邀请10个。你就有110次转盘机会，赚1650元。</li>
										</ul>
									</div>
									<a href="/member/re-route">
										<div class="btn-wabao">进入幸运转盘</div>
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

			$('#strSearch').focus(function(){
				if($(this).val() != ''){
		            $('#btn_clear').show();
					$('#btn_clear').click(function () { 
						$('#strSearch').val('');
						$(this).hide();
					});
				} else {
					$('#btn_clear').hide();
				}
			});

			$( "#strSearch" ).keyup(function() {
				if($(this).val() != ''){
		            $('#btn_clear').show();
					$('#btn_clear').click(function () { 
						$('#strSearch').val('');
						$(this).hide();
					});
				} else {
					$('#btn_clear').hide();
				}
			});

			if($( "#strSearch" ).val() != ''){
	            $('#btn_clear').show();
				$('#btn_clear').click(function () { 
					$('#strSearch').val('');
					$(this).hide();
				});
			} else {
				$('#btn_clear').hide();
			}

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
				$('.btn-product-details').attr('src', '/client/images/btn-redeem.png');
				$('#btn-copy').css('padding-top', '0.2rem');
				$('.btn-copy').html("领取优惠券");

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
				$( ".copyvoucher" ).html($(this).data('voucher'));

				var dd = $(this).data('imgurl');
				$("#showIcon").attr("src",dd);
				$( ".caption2" ).html($(this).data('tt_product_discount_price'));
				$( ".div_product_name" ).html($(this).data('tt_product_name'));
				$( ".span_price" ).html($(this).data('tt_product_price'));
				$( ".span_voucher_price" ).html($(this).data('tt_voucher_price'));
				
				being.wrapShow();
				being.scaleShow('.showQuan');
			});
			
			$('.freeVoucherBtn').click((e) => {
				being.wrapShow();
				being.scaleHide('.showQuan');
				being.scaleShow('.showTips');
			});

			//call from footer
			$('.main-footer').click((e) => {
				being.wrapShow();
				being.scaleHide('.showQuan');
				being.scaleShow('.showTips');
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

			var clipboard = new ClipboardJS('#btn-copy', {
				target: function () {
					return document.querySelector('#cut');
				}
			});
			clipboard.on('success', function (e) {
				console.log(e);
				$('.btn-product-details').attr('src', '/client/images/btn-copy-code.png');
				$('#btn-copy').css('padding-top', '0.1rem');
				$('.btn-copy').html("<p class='inner_span_copy1'>领取成功</p><p class='inner_span_copy2'>请打开淘宝APP</p>");

			});

			clipboard.on('error', function (e) {
				console.log(e);
				$('.btn-product-details').attr('src', '/client/images/btn-copy-code.png');
				$('#btn-copy').css('padding-top', '0.1rem');
				$('.btn-copy').html("<p class='inner_span_copy1'>领取成功</p><p class='inner_span_copy2'>请打开淘宝APP</p>");
			});

			being.scrollBottom('.cardBody', '.box', () => {

				page++;
				console.log(page);
				var max_page = parseInt($('#max_page').val());
				var strSearch = $('#strSearch').val();

				if(page > max_page && strSearch != '') {
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
		var strSearch = $('#strSearch').val();

		if(max_page == 0 && strSearch != ''){
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