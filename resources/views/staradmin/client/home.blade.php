@extends('layouts.layout2')

@section('title', trans('dingsu.home'))

@section('top-css')
    @parent
	<link rel="stylesheet" href="{{ asset('/client/css/home.css') }}" />

@endsection


@section('content')	

		<div class="container">
			<div class="card">
				<div class="title">超值试用<div class="button-wrapper"><button class="btn_recommend">每天10点更新</button></div></div>
			</div>
		</div>

		<div class="container full-height">
			
			<div class="listing">
				
			@if(count($vouchers))
			<div class="infinite-scroll">
			@foreach($vouchers as $item)
				
				<div class="row">
					<div class="col-xs-4 col-md-10">
						<a href="/details/{{$item->id}}">
							<img class="product" src="{{$item->product_picurl}}_460x460Q90.jpg" alt="{{$item->product_name}}">
						</a>
					</div>
					<div class="col-xs-8 col-md-10">
						<div class="description">{{$item->product_name}}</div>
						<div class="price">¥ {{$item->product_price}}</div>
						<div class="col-xs-6 promo-price">试用价19.9元</div>
						<a href="/arcade"><button  class="btn_wabao">免费挖宝</button></a>
					</div>

				</div>
				<br>
				@endforeach
				<br>
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
