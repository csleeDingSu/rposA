<link rel="stylesheet" href=" {{ asset('staradmin/css/voucher.css') }}"> {!! $result->render() !!}


<div class="row">
	<div class="col-md-3">
		<div class=" form-check form-check-flat">
			<label for="checkall" class="form-check-label">
							<input class="form-check-input " type="checkbox" name="checkall" id="checkall" onClick="return Checkall();"> @lang('dingsu.check_all')</label>
		
		</div>
	</div>

	<div class="col-sd-3">
		<select class="form-control" name="product_action" id="product_action">
			<option value="0">@lang('dingsu.default_select')</option>
			<option value="delete">@lang('dingsu.delete')</option>
			<option value="delete_all">@lang('dingsu.delete_all')</option>
		</select>
		<div>
		</div>
	</div>

	<div class="col-md-6">
		<a onClick="ProductAction()" data-token="{{ csrf_token() }}" href="#" class="btn btn-inverse-success  btn-outline-success btnsubmit" id="btnsubmit">@lang('dingsu.submit')</a>

	</div>
</div>


<form action="" name="productdisplayform" id="productdisplayform">

	<ul class="row list-unstyled productlist" id="productlist">
		@foreach($result as $item)

		<li class="divprolist_{{$item->id}} col-md-2 row is-flex justify-content-around mr-md-2 mt-2" id="divprolist_{{$item->id}}">

			<div class="d-flex justify-content-around">

				<div class="prolist_{{$item->id}} card ">
					<div class="card-body" onclick="CheckorUncheck('{{$item->id}}')">
						<input type="hidden" class="prc_{{$item->id}}" data-id="prc_{{$item->id}}" name="{{$item->id}}" id="prc[]" value="{{$item->id}}">

						<div class="price-off">{{$item->product_price}} $</div>
						<img class="card-img-top img-fluid" src="{{$item->product_picurl}}" alt="{{$item->product_name}}">
						<h5 class="card-title mt-0">{{$item->product_name}}</h5> {{$item->product_category}}
						<br> @lang('dingsu.month_sales'): {{$item->month_sales}}<br> @lang('dingsu.voucher_price'): {{$item->voucher_price}}<br> @lang('dingsu.upload_date'): {{ Carbon\Carbon::parse($item->created_at)->diffForHumans() }}<br>
						<br> @lang('dingsu.url'): {{ Config::get('app.shareurl') }}{{$item->id}} <br>						
					</div>

					<div class="card-body border-top pt-1 mt-auto d-flex align-items-end ">
						<div class="btn-toolbar">							
							<button type="button" onClick="return CopyUrl('{{ Config::get('app.shareurl') }}{{$item->id}}');return false;" class="btn btn-inverse-info  ">@lang('dingsu.copy') @lang('dingsu.url')</button>
						</div>
					</div>
				</div>
			</div>
		</li>
		@endforeach
	</ul>
</form> {!! $result->render() !!}

@unless (count($result))    
	@include ('common.norecord')
@endunless