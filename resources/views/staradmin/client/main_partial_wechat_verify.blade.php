<ul class="about">
  <li>①淘宝复制标题</li>
  <li>②搜索领券下单</li>
  <li>③领取奖励红包</li>
</ul>
<div class="ztBox ztBox2">
  <div class="total">
  </div>
  <div class="list2">
    <ul>
      <li>
        <span>
          <font color="#b168ff">152****2582</font>
        </span>
        <span>
          <font color="#5d5d5d">邀请2个好友</font>
        </span>
        <span>
          <font color="#ff5662">领到24元奖励红包</font>
        </span>
        <span>
          <font color="#ccc">刚刚</font>
        </span>
      </li>
      <li>
        <span>
          <font color="#b168ff">152****2582</font>
        </span>
        <span>
          <font color="#5d5d5d">邀请8个好友</font>
        </span>
        <span>
          <font color="#ff5662">领到96元奖励红包</font>
        </span>
        <span>
          <font color="#ccc">刚刚</font>
        </span>
      </li>
      <li>
        <span>
          <font color="#b168ff">152****2582</font>
        </span>
        <span>
          <font color="#5d5d5d">邀请10个好友</font>
        </span>
        <span>
          <font color="#ff5662">领到120元奖励红包</font>
        </span>
        <span>
          <font color="#ccc">08-08</font>
        </span>
      </li>
      <li>
        <span>
          <font color="#b168ff">152****2582</font>
        </span>
        <span>
          <font color="#5d5d5d">邀请2个好友</font>
        </span>
        <span>
          <font color="#ff5662">领到24元奖励红包</font>
        </span>
        <span>
          <font color="#ccc">08-08</font>
        </span>
      </li>
      <li>
        <span>
          <font color="#b168ff">152****2582</font>
        </span>
        <span>
          <font color="#5d5d5d">邀请8个好友</font>
        </span>
        <span>
          <font color="#ff5662">领到96元奖励红包</font>
        </span>
        <span>
          <font color="#ccc">08-08</font>
        </span>
      </li>
      <li>
        <span>
          <font color="#b168ff">152****2582</font>
        </span>
        <span>
          <font color="#5d5d5d">邀请10个好友</font>
        </span>
        <span>
          <font color="#ff5662">领到120元奖励红包</font>
        </span>
        <span>
          <font color="#ccc">08-08</font>
        </span>
      </li>
      <li>
        <span>
          <font color="#b168ff">152****2582</font>
        </span>
        <span>
          <font color="#5d5d5d">邀请10个好友</font>
        </span>
        <span>
          <font color="#ff5662">领到120元奖励红包</font>
        </span>
        <span>
          <font color="#ccc">08-08</font>
        </span>
      </li>
      <li>
        <span>
          <font color="#b168ff">152****2582</font>
        </span>
        <span>
          <font color="#5d5d5d">邀请10个好友</font>
        </span>
        <span>
          <font color="#ff5662">领到120元奖励红包</font>
        </span>
        <span>
          <font color="#ccc">08-08</font>
        </span>
      </li>
      <li>
        <span>
          <font color="#b168ff">152****2582</font>
        </span>
        <span>
          <font color="#5d5d5d">邀请10个好友</font>
        </span>
        <span>
          <font color="#ff5662">领到120元奖励红包</font>
        </span>
        <span>
          <font color="#ccc">08-08</font>
        </span>
      </li>
      <li>
        <span>
          <font color="#b168ff">152****2582</font>
        </span>
        <span>
          <font color="#5d5d5d">邀请10个好友</font>
        </span>
        <span>
          <font color="#ff5662">领到120元奖励红包</font>
        </span>
        <span>
          <font color="#ccc">08-08</font>
        </span>
      </li>
    </ul>

  </div>
  <a class="goShare" href="/pre-share"></a>
</div>


<div class="banner">
  <a><img src="{{ asset('/clientapp/images/banner.png') }}" width="100%"></a>
</div>


@section('footer-javascript')
    @parent  
    <script>

    $(function () {


      let ob = $('.list2 ul');

      var total = ob.find('li').length - 6;
      let num = 0;
      let height=ob.find('li').height();

      setInterval(function () {
        if (total > 0) {
          num++;
          if (num == total) {
            $('.list2 ul').animate({ 'top': '0px' });
            num = 1;
          }
          $('.list2 ul').stop().animate({ 'top': '-'+height * num + 'px' }, 200)
        }
      }, 3000);


    });




  </script>

@endsection

