@extends('layouts.layout2')

@section('title', trans('dingsu.home'))

@section('top-css')
    @parent
	<link rel="stylesheet" href="{{ asset('/client/css/home.css') }}" />

@endsection


@section('content')	


			

		<!-- End Static navbar -->
			
		<!-- Collect the nav links, forms, and other content for toggling -->
      
		
        
		
		<div class="wrapper full-height">
			<div class="card">
				<div class="title">超值试用<div class="button-wrapper"><button class="btn_recommend">每天10点更新</button></div></div>
			</div>
			
			<div class="listing">
				
			@if(count($vouchers))
			<div class="infinite-scroll">
			@foreach($vouchers as $item)
				
				<div class="row">
					<a href="/details/{{$item->id}}">
						<div class="col-xs-4">
							<img class="product" src="{{$item->product_picurl}}_460x460Q90.jpg_.webp" alt="{{$item->product_name}}">
						</div>
					</a>
					<div class="col-xs-8">
						<div class="description">{{$item->product_name}}</div>
						<div class="price">¥ {{$item->product_price}}</div>
						<div class="col-xs-6 promo-price"><a href="/details/{{$item->id}}">试用价19.9元</a></div>
						<div class="col-xs-5 view">已有15人申请</div>
					</div>
				</div>
				@endforeach
				
				{{ $vouchers->links() }}
			</div>
			@else
				<div class="infinite-scroll">
					<div class="row">
						<div class="col center">
							@lang('dingsu.no_record_found')
						</div>
					</div>
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
