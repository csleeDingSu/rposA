     
            
    @foreach($result as $list)
    <div class="col-md-3 stretch-card mt-3" id="product_{{$list->id}}">
                <div class="card">
                  <img class="card-img-top" src="{{$list->mainPic}}" alt="product images">
                  <div class="card-body pb-0">
                    <p class="text-muted">{{$list->title}}</p>


                    <div class="d-flex flex-row">
                      <div class="wrapper">
                        <h6 class="mb-0 text-muted">@lang('dingsu.product_price')</h6>
                        <div class="d-flex align-items-center">
                          <h4 class="font-weight-medium mb-0">{{$list->originalPrice}}</h4>
                        </div>
                      </div>
                      <div class="wrapper ml-4  pl-4">
                        <h6 class="mb-0 text-muted">@lang('dingsu.voucher_price')</h6>
                        <div class="float-right">
                          <h4 class="font-weight-medium mb-0">{{$list->couponPrice}}</h4>
                        </div>
                      </div>
                    </div>

                    <div class="d-flex flex-row">
                      <div class="wrapper">
                        <h6 class="mb-0 text-muted">@lang('dingsu.commission_rate')</h6>
                        <div class="">
                          <h4 class="font-weight-medium mb-0">{{$list->commissionRate}}</h4>
                        </div>
                      </div>
                      <div class="wrapper ml-4  pl-4 float-right">
                        <h6 class="mb-0 text-muted">@lang('dingsu.month_sales')</h6>
                        <div class="float-right">
                          <h4 class="font-weight-medium mb-0 text-right">{{$list->monthSales}}</h4>
                        </div>
                      </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-between text-muted mt-1">
                      <p class="mb-0">End {{$list->activityEndTime}}</p>
                    </div>

                    <div class="d-flex align-items-center justify-content-between text-muted border-top py-3 mt-3">
                      
                      <p class="mb-0">

               
                <button type="button" data-id="{{$list->id}}" onclick="return Gototop({{$list->id}})" id="moveproduct_{{$list->id}}" class="btn btn-inverse-warning gototop ">@lang('dingsu.change')</button>
                      </p>
                      
                    </div>
                  </div>
                </div>
              </div>

    @endforeach

