	<link rel="stylesheet" href="{{ asset('/client/fontawesome-free-5.5.0-web/css/all.css') }}" >
	<link rel="stylesheet" href="{{ asset('/client/bootstrap-3.3.7-dist/css/bootstrap.min.css') }}">

	<link rel="stylesheet" href="{{ asset('/test/main/css/public.css') }}" />
	<link rel="stylesheet" href="{{ asset('/test/main/css/module.css') }}" />
	<link rel="stylesheet" href="{{ asset('/test/main/css/style.css') }}" />
	<link rel="stylesheet" href="{{ asset('/test/main/css/main_pg_search.css') }}" />
	
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css" integrity="sha256-UK1EiopXIL+KVhfbFa8xrmAWPeBjMVdvYMYkTAEv/HI=" crossorigin="anonymous" />
	<link rel="stylesheet" href="{{ asset('/client/css/slick-theme.css') }}" />
	<link rel="stylesheet" href="{{ asset('/client/css/customer_service.css') }}"/>
	<link rel="stylesheet" href="{{ asset('/client/css/product.css') }}" />

	<script type="text/javascript" src="{{ asset('/test/main/js/jquery-1.9.1.js') }}" ></script>
	<script type="text/javascript" src="{{ asset('/test/main/js/being.js') }}" ></script>
	<script src="{{ asset('/client/js/js.cookie.js') }}"></script>


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
        var bdisable = true;

        if ((ua.indexOf("micromessenger") > -1 || ua.indexOf("qq/") > -1) && bdisable == false) {
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

<script>
//这个统计代码。
var hmt = hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "https://hm.baidu.com/hm.js?5e39d74009d8416a3c77c62c47158471";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>

<style>
	
	
.isnext{ text-align: center;font-size: .26rem; color: #999; line-height: 1.6em; padding: .15rem 0; }
	
	.header .top li a, .header .top li a:hover, .header .top li a:focus {
			text-decoration: none;
		}
		
	</style>

<input type="hidden" id="page" value="1" />
<input type="hidden" id="max_page" value="{{$vouchers->lastPage()}}" />
<input type="hidden" id="firstwin" value="{{ $firstwin }}" />
<input type="hidden" id="initialIndex" value="{{ $cid }}" />

	<section class="cardFull card-flex product_section">
		<div class="cardHeader">
			<div class="header">
				<div class="main rel">
					<div class="dbox">
						<div class="dbox1 txt">
							<div class="carousel">
							{{$current_cat_name = null}}
							@if(isset($category))
								@foreach($category as $cat)
									
									@if($cat->display_name == '文娱车品' || $cat->display_name == '数码电器')								
										@if ($cat->id == $cid)
											<a class="carousel-cell on is-selected carousel-cell-long" href="/arcade/{{$cat->id}}">{{$cat->display_name}}</a>
											@php @$current_cat_name = $cat->display_name @endphp
										@else
											<a class="carousel-cell carousel-cell-long" href="/arcade/{{$cat->id}}">{{$cat->display_name}}</a>
										@endif
									@else
										@if ($cat->id == $cid)
											<a class="carousel-cell on is-selected" href="/arcade/{{$cat->id}}">{{$cat->display_name}}</a>
											@php @$current_cat_name = $cat->display_name @endphp
										@else
											<a class="carousel-cell" href="/arcade/{{$cat->id}}">{{$cat->display_name}}</a>
										@endif
									@endif

								@endforeach
							@else
								<a class="on">精选</a>
								<a class="carousel-cell">男装</a>
								<a class="carousel-cell">鞋帽</a>
								<a class="carousel-cell">女装</a>
								<a class="carousel-cell">食饮</a>
								<a class="carousel-cell">没装</a>
							@endif
							</div>							
						</div>
						<a class="downIcon dbox0"><img src="{{ asset('/test/main/images/downIcon.png') }}"></a>
					</div>
					<div class="slideMore dn">
						<h2>全部分类<a class="close"><img src="{{ asset('/test/main/images/closeIcon.png') }}"></a></h2>
						<p>
							@foreach($category as $cat)
								@if ($cat->id == $cid)
									<a class="on" href="/arcade/{{$cat->id}}">{{$cat->display_name}}</a>
								@else
									<a href="/arcade/{{$cat->id}}">{{$cat->display_name}}</a>
								@endif
							@endforeach							
						</p>
					</div>
				</div>
			</div>
		</div>
		<div class="cardBody">
			<div class="box">
				<div class="product" style="margin-top: 0px;">					
					<div class="infinite-scroll">
						<ul class="list-2">								
								@include('client.ajaxhome')
						</ul>
						{{ $vouchers->links() }}
						
						<p class="isnext">下拉显示更多...</p>
					</div>
					
				</div>
			</div>
		</div>

		<div class="speech-balloon-home hide">你有{{ isset(Auth::Guard('member')->user()->current_life) ? Auth::Guard('member')->user()->current_life : 0}}次机会，可赚{{ isset(Auth::Guard('member')->user()->current_life) ? Auth::Guard('member')->user()->current_life * 15 : 0}}元免单红包</div>

		<div class="openFrom">
			<div class="div-instruction">
				<ul class="instruction-list">
					<li>
						<div class="instruction-background">
							<img src="{{ asset('/client/images/search/copy.png') }}" />
						</div>
					</li>
					<li>打开手机淘宝/天猫，长按商品标题“拷贝”</li>
					<li>粘贴搜索框，查找优惠卷</li>
				</ul>
			</div>
		</div>
			
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
							<span>99%中奖 最少15元</span>
							<img src="{{ asset('/client/images/caption_redeem_angpao.png') }}" />
						</div>
						<img class="btn-product-details" src="{{ asset('/client/images/btn-redeem-main.png') }}" />
						<div id="btn-copy" class="btn-copy">领取优惠券</div>
						<div id="btn-voucher" class="freeVoucherBtn"><span>转盘抽奖</span></div>
					</div>
					<h4 style="font-size: 0;">优惠券代码 <span id="cut" class="copyvoucher" style="font-size: 0;">￥K8454DFGH45H</span></h4>

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
	
	<!-- customer service modal -->
<div class="modal fade col-md-12" id="csModal" tabindex="-1" role="dialog" aria-labelledby="viewvouchermodellabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-title">
			<h1><img src="{{ asset('/client/images/weixin.png') }}" width="30" height="29" /> 请加客服微信</h1>
		</div>
		<div class="modal-content modal-wechat">
			<div class="modal-body">
				<div class="modal-row">
					<div class="wrapper modal-full-height">
						<div class="modal-card">
							<div class="instructions">
								客服微信在线时间：<span class="highlight">早上9点~晚上9点</span>
							</div>
						</div>
						<div class="row">
							<div id="cutCS" class="copyid">{{env('wechat_id', 'BCKACOM')}}</div>
							<div class="cutBtn">点击复制</div>
						</div>
						<div class="modal-card">
							<div class="instructions-dark">
								请按复制按钮，复制成功后到微信添加。<br/> 如复制不成功，请到微信手动输入添加。
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- customer service modal Ends -->

	<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js" integrity="sha256-NXRS8qVcmZ3dOv3LziwznUHPegFhPZ1F/4inU7uC8h0=" crossorigin="anonymous"></script>
	<script src="{{ asset('/client/bootstrap-3.3.7-dist/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('/test/main/js/clipboard.min.js') }}" ></script>
	<script src="{{ asset('/client//unpkg.com/flickity@2/dist/flickity.pkgd.min.js') }}"></script>
	<script>
		
		$(document).on('ready', function() {
      
		  $(".banner").slick({
			  autoplay:true,
			  autoplaySpeed:10000,
			  arrows:false,
			  lazyLoad: 'ondemand', // ondemand progressive anticipated
			  infinite: true,
			  adaptiveHeight: false,
			  dots: true,
		  });
		});
		
		
		

		$(document).ready(function(){
		//$(function () {
			$('#strSearch').focus(function(){
				$('.logo').hide();
				$(this).parent().addClass('enlarge');
				$('.customer').html('<a href="javascript:void(0)"><div class="cancel">取消</div></a>');

	            $(".openFrom").slideDown(150);

	            $('.cancel').click(function(){
					$('.logo').show();
					$('.flexSp').removeClass('enlarge');
					$('.customer').html('<a href="javascript:void(0)" id="customerservice" class="customerservice"><img src="/client/images/search/customer.png"><div class="caption">在线客服</div></a>');
					$('#customerservice').click(function () { 
						$('#csModal').modal('show');
					});

	                $(".openFrom").slideUp(150);

	                $('#btn_clear').hide();

	                if($('#strSearch').val() != ''){
	                	$('#strSearch').addClass('clear');
			            $('#btn_clear').show();
						$('#btn_clear').click(function () { 
							$('#strSearch').val('');
							$(this).hide();
						});
					} else {
						$('#strSearch').removeClass('clear');
						$('#btn_clear').hide();
					}
				});

				if($(this).val() != ''){
					$('#strSearch').addClass('clear');
		            $('#btn_clear').show();
					$('#btn_clear').click(function () { 
						$('#strSearch').val('');
						$(this).hide();
						$('#strSearch').removeClass('clear');
					});
				} else {
					$('#strSearch').removeClass('clear');
					$('#btn_clear').hide();
				}
			});

			$( "#strSearch" ).keyup(function() {
				if($(this).val() != ''){
					$('#strSearch').addClass('clear');
		            $('#btn_clear').show();
					$('#btn_clear').click(function () { 
						$('#strSearch').val('');
						$(this).hide();
						$('#strSearch').removeClass('clear');
					});
				} else {
					$('#strSearch').removeClass('clear');
					$('#btn_clear').hide();
				}
			});

			$('#customerservice').click(function () { 
				$('#csModal').modal('show');
			});

			var clipboardCS = new ClipboardJS('.cutBtn', {
                target: function () {
                    return document.querySelector('#cutCS');
                }
            });
            clipboardCS.on('success', function (e) {
                $('.cutBtn').addClass('cutBtn-success').html('<i class="far fa-check-circle"></i>复制成功');
            });

            clipboardCS.on('error', function (e) {
                 // $('.cutBtn').addClass('cutBtn-fail').html('<i class="far fa-times-circle"></i>复制失败');
                $('.cutBtn').addClass('cutBtn-success').html('<i class="far fa-check-circle"></i>复制成功');
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

			var initialIndex = $('#initialIndex').val();
			var $carousel = $('.carousel').flickity({
					prevNextButtons: false,
					pageDots: false,
					contain: true,
					initialIndex: initialIndex
				});

			$carousel.on( 'staticClick.flickity', function( event, pointer, cellElement, cellIndex ) {
			  if ( typeof cellIndex == 'number' ) {
			    $carousel.flickity( 'selectCell', cellIndex );
			  }
			});

			//removed not require to show
			// var firstwin = $('#firstwin').val();
			// console.log(firstwin);

			// if(firstwin == 'yes'){
			// 	$(document).click(function() {
			// 		$('.speech-balloon-home').hide();
			// 		$.ajax({
			// 	         url: "/firstwin"
			// 	    });
			// 	});
				
			// 	$('.speech-balloon-home').removeClass('hide').animate({'margin-top': '-1.4rem'}, 500);
			// }
			
			$('.downIcon').click(function () {
				$('.cardHeader').css({ 'z-index': '11' });
				being.wrapShow('.cardBody');
				$('.slideMore').fadeIn(150);
			});

			$('.slideMore .close').click(function () {
			
				$('.slideMore').fadeOut(150);
				being.wrapHide('.cardBody', () => {
					$('.cardHeader').removeAttr('style');
				});
			});
			
			$('.showQuan').click((e) => {
				$('.btn-product-details').attr('src', '/client/images/btn-redeem-main.png');
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
				window.location.href = '/intro';
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
				
				$( ".copyvoucher" ).html($(this).data('voucher'));

				$( ".caption2" ).html($(this).data('tt_product_discount_price'));
				$( ".div_product_name" ).html($(this).data('tt_product_name'));
				$( ".span_price" ).html($(this).data('tt_product_price'));
				$( ".span_voucher_price" ).html($(this).data('tt_voucher_price'));		

				being.wrapShow();
				being.scaleShow('.showQuan');
			});

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
				$('.btn-product-details').attr('src', '/client/images/btn-copy-code-main.png');
				$('#btn-copy').css('padding-top', '0.1rem');
				$('.btn-copy').html("<p class='inner_span_copy1'>领取成功</p><p class='inner_span_copy2'>请打开淘宝APP</p>");

			});

			clipboard.on('error', function (e) {
				console.log(e);
				$('.btn-product-details').attr('src', '/client/images/btn-copy-code-main.png');
				$('#btn-copy').css('padding-top', '0.1rem');
				$('.btn-copy').html("<p class='inner_span_copy1'>领取成功</p><p class='inner_span_copy2'>请打开淘宝APP</p>");
			});

			being.scrollBottom('.cardBody', '.box', () => {			
				page++;
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
		
		/*$('.cardBody').on('scroll', function() {
        	if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {            
				//scroll
			}
		})*/
				
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