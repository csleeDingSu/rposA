@extends('layouts.default_app')

@section('top-css')
    @parent  
@endsection

@section('top-javascript')
    @parent
    
@endsection

@section('title', '晒单评论')

@section('top-navbar')    
@endsection

@section('content')

        <div class="logo rel">
          <img src="{{ asset('/clientapp/images/logo.png') }}" width="100%">
          <div class="searchBox">
            <img src="{{ asset('/clientapp/images/searchIcon.png') }}">
            <label>
              <input type="text" placeholder="复制淘宝商品标题 粘贴搜索">
            </label>
            <a>查券</a>
          </div>
        </div>
        <ul class="about">
          <li>①打开淘宝app</li>
          <li>②复制商品标题</li>
          <li>③粘贴搜索</li>
        </ul>
        <div class="ztBox">
          <div class="total">
            <span>今日已领取</span>
            <i>2</i>
            <i>2</i>
            <i>2</i>
            <i>2</i>
            <span>元</span>
          </div>
          <div class="list">
            <a href="#">
              <span><img src="{{ asset('/clientapp/images/demoImg2.png') }}"></span>
              <h2>¥ 3.0</h2>
              <p>热销1.7万件</p>
            </a>
            <a href="#">
              <span><img src="{{ asset('/clientapp/images/demoImg2.png') }}"></span>
              <h2>¥ 3.0</h2>
              <p>热销1.7万件</p>
            </a>
            <a href="#">
              <span><img src="{{ asset('/clientapp/images/demoImg2.png') }}"></span>
              <h2>¥ 3.0</h2>
              <p>热销1.7万件</p>
            </a>
          </div>
        </div>


        <div class="banner">
          <a><img src="{{ asset('/clientapp/images/banner.png') }}" width="100%"></a>
        </div>
        <h2 class="listTitle">超值爆款产品</h2>
        <div class="listBox">
          <div class="inBox">
            <div class="imgBox">
              <img src="{{ asset('/clientapp/images/demoImg.png') }}">
            </div>
            <div class="txtBox flex1">
              <h2 class="name">【第二件0元】海底捞牛油火锅底料</h2>
              <div class="typeBox">
                <span class="type-red">20元</span>
                <span class="type-sred">奖励100积分</span>
                <span class="type-blue">抽奖补贴12元</span>
              </div>
              <div class="moneyBox">
                <p class="icon">¥</p>
                <p class="nowTxt">3.0</p>
                <p class="oldTxt">35.00</p>
                <a href="#" class="btn">
                  <p>热销1.7万</p>
                  <div class="inTxt">
                    <img src="{{ asset('/clientapp/images/shapeIcon.png') }}">
                    <span>去领券</span>
                  </div>
                </a>
              </div>
            </div>
          </div>
          <div class="inBox">
            <div class="imgBox">
              <img src="{{ asset('/clientapp/images/demoImg.png') }}">
            </div>
            <div class="txtBox flex1">
              <h2 class="name">【第二件0元】海底捞牛油火锅底料</h2>
              <div class="typeBox">
                <span class="type-red">20元</span>
                <span class="type-sred">奖励100积分</span>
                <span class="type-blue">抽奖补贴12元</span>
              </div>
              <div class="moneyBox">
                <p class="icon">¥</p>
                <p class="nowTxt">3.0</p>
                <p class="oldTxt">35.00</p>
                <a href="#" class="btn">
                  <p>热销1.7万</p>
                  <div class="inTxt">
                    <img src="{{ asset('/clientapp/images/shapeIcon.png') }}">
                    <span>去领券</span>
                  </div>
                </a>
              </div>
            </div>
          </div>
          <div class="inBox">
            <div class="imgBox">
              <img src="{{ asset('/clientapp/images/demoImg.png') }}">
            </div>
            <div class="txtBox flex1">
              <h2 class="name">【第二件0元】海底捞牛油火锅底料</h2>
              <div class="typeBox">
                <span class="type-red">20元</span>
                <span class="type-sred">奖励100积分</span>
                <span class="type-blue">抽奖补贴12元</span>
              </div>
              <div class="moneyBox">
                <p class="icon">¥</p>
                <p class="nowTxt">3.0</p>
                <p class="oldTxt">35.00</p>
                <a href="#" class="btn">
                  <p>热销1.7万</p>
                  <div class="inTxt">
                    <img src="{{ asset('/clientapp/images/shapeIcon.png') }}">
                    <span>去领券</span>
                  </div>
                </a>
              </div>
            </div>
          </div>
          <div class="inBox">
            <div class="imgBox">
              <img src="{{ asset('/clientapp/images/demoImg.png') }}">
            </div>
            <div class="txtBox flex1">
              <h2 class="name">【第二件0元】海底捞牛油火锅底料</h2>
              <div class="typeBox">
                <span class="type-red">20元</span>
                <span class="type-sred">奖励100积分</span>
                <span class="type-blue">抽奖补贴12元</span>
              </div>
              <div class="moneyBox">
                <p class="icon">¥</p>
                <p class="nowTxt">3.0</p>
                <p class="oldTxt">35.00</p>
                <a href="#" class="btn">
                  <p>热销1.7万</p>
                  <div class="inTxt">
                    <img src="{{ asset('/clientapp/images/shapeIcon.png') }}">
                    <span>去领券</span>
                  </div>
                </a>
              </div>
            </div>
          </div>
          <div class="inBox">
            <div class="imgBox">
              <img src="{{ asset('/clientapp/images/demoImg.png') }}">
            </div>
            <div class="txtBox flex1">
              <h2 class="name">【第二件0元】海底捞牛油火锅底料</h2>
              <div class="typeBox">
                <span class="type-red">20元</span>
                <span class="type-sred">奖励100积分</span>
                <span class="type-blue">抽奖补贴12元</span>
              </div>
              <div class="moneyBox">
                <p class="icon">¥</p>
                <p class="nowTxt">3.0</p>
                <p class="oldTxt">35.00</p>
                <a href="#" class="btn">
                  <p>热销1.7万</p>
                  <div class="inTxt">
                    <img src="{{ asset('/clientapp/images/shapeIcon.png') }}">
                    <span>去领券</span>
                  </div>
                </a>
              </div>
            </div>
          </div>
          <div class="lastHint">下拉显示更多产品...</div>
        </div>
        <hr class="h36">
@endsection

@section('footer-javascript')
    @parent  

@endsection