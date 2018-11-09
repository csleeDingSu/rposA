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
	<title>首页</title>	
	
	<link rel="stylesheet" href=" {{ asset('ad/css/public.css') }}">
	<link rel="stylesheet" href=" {{ asset('ad/css/module.css') }}">
	<link rel="stylesheet" href=" {{ asset('ad/css/style.css') }}">
	
	
	<script type="text/javascript" src="{{ asset('ad/js/jquery-1.9.1.js') }}"></script>	
	<script type="text/javascript" src="{{ asset('ad/js/being.js') }}"></script>
			
</head>

<body>
	<section class="card">
		
		<div class="showBox dn">
			<div class="showIn dflex scaleHide">
				<div class="inBox">
					<img src="{{ asset('ad/images/wxIcon.png') }}" class="wxIcon">
					<h2>请加客服微信&nbsp;领取优惠券</h2>
					<h5 class="showcode">WABAO8877</h5>
					<a class="cutBtn"><img src=" {{ asset('ad/images/cut.png') }}"></a>
					<h3>如果点击按钮复制不成功，请到微信手动输入添加。</h3>
				</div>
			</div>
		</div>
		
		<div class="card-body">
			<div class="header">
				<img src="{{ asset('ad/images/ad.jpg') }}">
				<div class="inBox">
					<div class="test">
						<h2>加客服微信&nbsp;天天领优惠券</h2>
						<p>WABAO8877</p>
					</div>
				</div>
			</div>
			<div class="title">
				<span>共有<font color="#fe556a">{{ $result->total() }}</font>款</span>
				<p>今日优惠精选</p>
			</div>
			
			<div class="infinite-scroll">				
				
			<ul class="list">
				@include('ad.ajaxlist')
			</ul>
			{{ $result->links() }}
				<p class="isnext">下拉显示更多...</p>
			</div>
			
		</div>
		
	</section>
	
<input type="hidden" id="page" value="1" />
<input type="hidden" id="max_page" value="{{$result->lastPage()}}" />

	
	<script src="{{ asset('ad/js/clipboard.min.js') }}"></script> 
	
	
	<script>
			
$(function () {
	
			$( ".infinite-scroll" ).on( "click", ".quan a", function ( e ) {
			//$('.quan a').click(function () {				
				//var id =$(this).attr("data-id");
				//$('.showcode').html(id);				
				$('.showBox').fadeIn(150, function () {
					being.scaleShow('.showIn');
				});
			});
	
			$('.showBox').click(function (e) {
				console.log(e);
				var target = $(e.target).closest('.inBox').length;
				console.log(target);
				if (target > 0) {
					return;
				} else {
					being.scaleHide('.showIn');
					$('.showBox').fadeOut(150);
					$('.cutBtn img').attr('src', "{{ asset('ad/images/cut.png') }}");
				}
			});
	
			
			being.scrollBottom('.card', '.card-body', () => {	
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
			/*

			being.scrollBottom('.card', '.card-body', () => {
				//滚到到底部执行动作

				//添加
				var html = '';
				html += '<li class="dbox opacity2">';	
				html += '<a href="#" class="imgBox dbox0">';
				html += '<img src="'+"{{ asset('ad/images/demoImg.png') }}"+'">'; 
				html += '</a>';
				html += '<div class="dbox1">';
				html += '<h2>美的电热水壶家用204不锈钢正面电热烧水壶自动断电保温大开水壶</h2>';
				html += '<h3>';
				html += '<font>券后价¥2.9</font>淘宝原价129.9元';
				html += '</h3>';		
				html += '<div class="quan">';
				html += '<span>¥100元券<font>剩三张</font></span>';
				html += '<a>微信领取</a>';
				html += '</div>';
				html += '</div>';
				html += '</li>';
				$('.list').append(html);
			
				//暂无更多
				//$('.isnext').html('暂无更多...');
			}); 
			*/

		})
		var clipboard = new ClipboardJS('.cutBtn', {
			target: function () {
				return document.querySelector('h5');
			}
		});

		clipboard.on('success', function (e) {
			console.log(e);
			$('.cutBtn img').attr('src', "{{ asset('ad/images/cutYes.png') }}");
		});

		clipboard.on('error', function (e) {
			console.log(e);
			$('.cutBtn img').attr('src', "{{ asset('ad/images/cutNo.png') }}");
		});
		
		$('ul.pagination').hide();	
	 	var page=1;
		
		function getPosts(page){
			$.ajax({
				type: "GET",
				url: "{{url()->current()}}?page"+page, 
				data: { page: page },
				beforeSend: function(){ 
				},
				complete: function(){ 
				  $('#loading').remove
				},
				success: function(responce) { 
					$('.list').append(responce.html);
				}
			 });
		}
		
		$('.card-body').on('scroll', function() {
				if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {            
					//scroll
					alert();
				}
			})
		
		/*
        $('.infinite-scroll').jscroll({
            autoTrigger: true,
            debug: false,
            loadingHtml: '<p class="isnext">下拉显示更多...</p>',
            padding: 0,
            nextSelector: '.pagination li.active + li a',
            contentSelector: '.infinite-scroll',
            callback: function() {
                $('ul.pagination').remove();
            },
        });
		*/
	</script>

</body>

</html>