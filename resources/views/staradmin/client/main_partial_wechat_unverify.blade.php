<ul class="about">
  <li>①打开淘宝app</li>
  <li>②复制商品标题</li>
  <li>③粘贴搜索</li>
</ul>
<div class="ztBox">
  <div class="total">
    <span>今日已领取</span>
	  @foreach($total_redeem as $tr)
	  	<i>{{$tr ?? '0'}}</i>
	  @endforeach
    
    <span>元</span>
  </div>
  <div class="list highlight-list">
    <a href="#">
      <span><img src="{{ asset('/clientapp/images/demoImg2.png') }}"></span>
      <h2><em>¥</em> 3.0</h2>
      <p>热销1.7万件</p>
    </a>
    <a href="#">
      <span><img src="{{ asset('/clientapp/images/demoImg2.png') }}"></span>
      <h2><em>¥</em> 3.0</h2>
      <p>热销1.7万件</p>
    </a>
    <a href="#">
      <span><img src="{{ asset('/clientapp/images/demoImg2.png') }}"></span>
      <h2><em>¥</em> 3.0</h2>
      <p>热销1.7万件</p>
    </a>
  </div>
  <a class="goShare" href="/arcade"></a>
</div>


<div class="banner">
  <a href="/vip"><img src="{{ asset('/clientapp/images/banner.png') }}" width="100%"></a>
</div>          
