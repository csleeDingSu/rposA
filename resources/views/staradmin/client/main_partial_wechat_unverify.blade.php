<ul class="about">
  <li>①打开淘宝app</li>
  <li>②复制商品标题</li>
  <li>③粘贴搜索</li>
</ul>
<div class="ztBox">
  <div class="total">
    <span>今日已领</span>
	 
	  @foreach($total_redeem as $tr)
	  	<i>{{$tr ?? '0'}}</i>
	  @endforeach
    
    <span>元</span>
  </div>
  <div class="list highlight-list">
    @if(!empty($product))
      @php ($i = 0)
      @foreach($product['list'] as $p)
        @php ($i++)
        @php ($newPrice = $p['originalPrice'] - $p['couponPrice'] - 12)
        @php ($newPrice = ($newPrice > 0) ? $newPrice : 0)
        @php ($sales = ($p['monthSales'] >= 1000) ? number_format(((float)$p['monthSales'] / 10000), 2, '.', '') . '万' : $p['monthSales'] . '件')
        @php ($_param = "?id=" . $p['id'] . "&goodsId=" . $p['goodsId'] . "&mainPic=" . $p['mainPic'] . "&title=" . $p['title'] . "&monthSales=" . $p['monthSales'] . "&originalPrice=" . $oldPrice . "&couponPrice=" . $p['couponPrice'] . "&couponLink=" . urlencode($p['couponLink']) . "&voucher_pass=")

        <a href="/main/product/detail{{$_param}}">
          <span><img src="{{ $p['mainPic'] }}"></span>
          <h2><em>¥</em>{{$newPrice}}</h2>
          <p>热销{{$sales}}</p>
        </a>    

        @if ($i == 3)
          @break
        @endif
      @endforeach
    @else
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
    @endif
  </div>
  <a class="goShare" href="/arcade"></a>
</div>


<div class="banner">
  <a href="/vip"><img src="{{ asset('/clientapp/images/banner.png') }}" width="100%"></a>
</div>          
