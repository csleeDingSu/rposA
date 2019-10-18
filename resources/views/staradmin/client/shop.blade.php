@extends('layouts.default_app')

@section('title', '商城')

@section('top-css')
    @parent
    <link rel="stylesheet" href="{{ asset('/clientapp/css/shop.css') }}" />
    <link rel="stylesheet" href="{{ asset('/client/css/productv2.css') }}" />
    
@endsection

@section('top-navbar')    
@endsection

@section('content')
    <input id="hidUserId" type="hidden" value="" />
    
    <div class="card-header">
        <div class="header-line">            
              <div class="shop-left-menu">
                <img class="clscoin" src="{{ asset('/clientapp/images/shop/coin.png') }}">
                <div class="shop-balance">99999.99</div>
                <a href="javascript:openModal('faq-coinsource');">
                  <img class="clsquestion" src="{{ asset('/clientapp/images/shop/question-icon.png') }}">
                </a>
              </div>
            <a class="shop-right-menu" href="/redeem-vip-new"><img src="{{ asset('/clientapp/images/shop/icon-my-redeem.png') }}"></a>
        </div>
        <div class="shop-banner"></div>
        <div class="shop-notification">
          <div class="txt-ellipsis">
            @if (!empty($buy))
              @foreach($buy as $b)
                <span class="highlight">{{ substr($b->phone,0,3) }}*****{{ substr($b->phone, -4) }} </span> 换购 {{$b->package_name}}
              
              @endforeach
            @else
              <span class="highlight">158*****2686</span> 换购 iPhone X 256G 深黑色全网通苹果智能手机
            @endif
          </div>
        </div>
    </div>

    <div class="redeem-prize-wrapper"></div>

    <hr class="h36">

@endsection

@section('footer-javascript')
  <!-- insufficient point modal -->
    <div class="modal fade col-md-12" id="modal-insufficient-point" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="insufficient-point">挖宝币不足 请先充值或兑换</div>                  
        </div>
    </div>
    <!-- insufficient point modal Ends -->
    
    <!-- haven't login start modal -->
    <div class="modal fade col-md-12" id="modal-no-login" tabindex="-1" role="dialog" aria-labelledby="viewvouchermodellabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="nologin-bg">
                <div class="instructions"><span class="highlight">无限制抽奖</span> 任你抽到爽</div>
                <div class="instructions"><span class="highlight">卡券奖品</span> 拿到手软</div>
                <div class="instructions"><span class="highlight">100%随机</span> 绝无作弊</div>          
                <a href="/nlogin">
                    <div class="btn-login"></div>
                </a>
            </div>      
        </div>
    </div>
    <!-- haven't login modal Ends-->

    <!-- redeem Rules starts -->
      <div class="modal fade col-md-12" id="redeem-rules" tabindex="-1" role="dialog" aria-labelledby="viewvouchermodellabel" aria-hidden="true" style="background-color: rgba(17, 17, 17, 0.65);">
        <div class="modal-dialog modal-lg close-modal" role="document">
          <div class="modal-content">
              <div class="modal-title">
                换购规则说明
              </div>
              <div class="instructions">
                <p>
                  通过抽奖赚的金币可以用来兑换平台的所有产品，金币抵现金，购物不花钱。
                </p>
                <p>
                  挑选换购产品，兑换成功后，平台发货，每次换购完会自动扣除等值金币。
                </p>
              </div>
              <div class="modal-close-btn">
                知道了
              </div>        
            
          </div>
        </div>
      </div>

      <!-- question starts -->
      <div class="modal fade col-md-12" id="faq-coinsource" tabindex="-1" role="dialog" aria-labelledby="viewvouchermodellabel" aria-hidden="true" style="background-color: rgba(17, 17, 17, 0.65);">
        <div class="modal-dialog modal-lg close-modal" role="document">
          <div class="modal-content">
              <div class="modal-title">
                金币来源
              </div>
              <div class="instructions">
                <p>
                    通过高级抽奖专场，抽奖赚得金币。
                  </p>
                  <p>
                    通过普通抽奖获得购物补贴红包，红包可兑换挖宝币。
                  </p>
                  <p>
                    兑奖奖品自动扣除等值金币。
                  </p>
              </div>
              <div class="modal-close-btn">
                知道了
              </div>        
            
          </div>
        </div>
      </div>
      
    @parent
    <script src="{{ asset('/clientapp/js/shop.js') }}"></script>
    <script type="text/javascript">
      
        $(document).ready(function() {
            var user_id = "<?php Print(isset(Auth::Guard('member')->user()->id) ? Auth::Guard('member')->user()->id : 0);?>";
            var wechat_status = "<?php Print(isset($member->wechat_verification_status) ? $member->wechat_verification_status : 0);?>";
            var normal_game_point = getNumeric("<?php Print(empty($wallet['gameledger']['102']->point) ? 0 : $wallet['gameledger']['102']->point);?>");
            var current_point = getNumeric("<?php Print(empty($wallet['gameledger']['103']->point) ? 0 : $wallet['gameledger']['103']->point);?>");
            var usedpoint = getNumeric("<?php Print(empty($wallet['gameledger']['102']->used_point) ? 0 : $wallet['gameledger']['102']->used_point);?>");

            $('#hidUserId').val(user_id);
            $('.shop-balance').html(current_point);

            $('.modal-close-btn').click(function () {
                  $('.modal').modal('hide');
                  $('.modal-backdrop').remove();
              });
        });

        function openModal(id) {
            $('#' + id).modal();
        }


    </script>

@endsection

<!-- socket start-->  
<script type="text/javascript">
  @section('socket')
  @parent
    var id = "<?php Print(isset(Auth::Guard('member')->user()->id) ? Auth::Guard('member')->user()->id : 0);?>";
    console.log('prefix --- ' + prefix);
    console.log('id --- ' + id);

    socket.on(prefix+ id + "-ledger" + ":App\\Events\\EventLedger" , function(data){
        console.log(prefix+ id + "-ledger" + ":App\\Events\\EventLedger");
        console.log(data.data);
        var gameid = data.data.game_id;

        if (gameid == 103) {
          var previous_103_point = $('.shop-balance').html();
          var updated_103_point = data.data.point;
          if (!(previous_103_point == updated_103_point)) {
            $('.shop-balance').html(updated_103_point); 
          }
          
        }
    });

  @endsection
</script>
<!-- socket end-->
