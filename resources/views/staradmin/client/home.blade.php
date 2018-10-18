@extends('layouts.layout2')

@section('title', trans('dingsu.home'))

@section('top-css')
    @parent
	<link rel="stylesheet" href="{{ asset('/client/css/home.css') }}" />

@endsection


@section('content')	

		<div class="container" style="border-bottom: 1px solid #394165;">
			
			<div class="title">超值试用
			<button class="btn_recommend">每天10点更新</button></div>
		</div>


		<div class="container" style="background-color: white;">
			
			<div class="listing">
				
			@if(count($vouchers))
			<div class="infinite-scroll">
			@foreach($vouchers as $item)
				
				<div class="row" style="border-bottom: 1px solid #394165;">
					<div class="col-sm-3">
						<a href="/details/{{$item->id}}">
							<img class="product" src="{{$item->product_picurl}}_460x460Q90.jpg_.webp" alt="{{$item->product_name}}">
						</a>
					</div>
					<div class="col-sm-9">
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

@endsection
