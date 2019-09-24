<ul class="about">
  <li>①淘宝复制标题</li>
  <li>②搜索领券下单</li>
  <li>③领取奖励红包</li>
</ul>
<div class="ztBox ztBox2">
  <div class="total">
  </div>
  <div class="list2">
    <ul class="list-data">
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
  <a href="/vip"><img src="{{ asset('/clientapp/images/banner.png') }}" width="100%"></a>
</div>


@section('footer-javascript')
    @parent  
    <script>

    $(function () {

      var html = '';

      $.ajax({
            type: "GET",
            url: "/api/invitation-list?limit=50&offset=0",
            dataType: "json",
            error: function (error) { console.log(error) },
            success: function(data) {
                // console.log(data);
                d = data.records;
                $.each(d, function(i, item) {
                  // console.log(item.phone);
                  var _phone = (item.phone === null) ? '*****' : (item.phone.substring(0,3) + '*****' + item.phone.slice(-4));
                  var _invite = item.totalcount;
                  var _gain = _invite * 12;

                  var requested_time = item.created_at;
                  var today = new Date();
                  var Christmas = new Date(requested_time);
                  var diffMs = (today - Christmas); // milliseconds between now & Christmas
                  var diffDays = Math.floor(diffMs / 86400000); // days
                  var diffHrs = Math.floor((diffMs % 86400000) / 3600000); // hours
                  var diffMins = Math.round(((diffMs % 86400000) % 3600000) / 60000); // minutes

                  var _date = '刚刚';
                  if(diffMins > 0 && diffMins < 60){
                      _date = diffMins + "分钟";
                  }else if (diffMins >= 60){
                      _date = diffHrs + "小时"
                  }

                  html += '<li>' +
                            '<span>' +
                              '<font color="#b168ff">'+_phone+'</font>' +
                            '</span>' +
                            '<span>' +
                              '<font color="#5d5d5d">邀请'+_invite+'个好友</font>' +
                            '</span>' +
                            '<span>' +
                              '<font color="#ff5662">领到'+_gain+'元奖励红包</font>' +
                            '</span>' +
                            '<span>' +
                              '<font color="#ccc">'+_date+'</font>' +
                            '</span>' +
                          '</li>';
                });

                $('.list-data').prepend(html);
                // $('.list-data').append(html);
            }
        });


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

