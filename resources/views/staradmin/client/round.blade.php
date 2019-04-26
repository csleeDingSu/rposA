@extends('layouts.default')

@section('title', '我的场次')

@section('left-menu')
    <a href="/profile" class="back">
        <img src="{{ asset('/client/images/back.png') }}" width="11" height="20" />
    </a>
@endsection

@section('top-css')
    @parent
	<link rel="stylesheet" href="{{ asset('/client/css/round.css') }}" />
@endsection

@section('top-javascript')
    @parent
    <script src="{{ asset('/client/ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/test/main/js/being.js') }}" ></script>
@endsection

@section('content')
<div class="full-height">
    <div class="container">
        <input id="hidUserId" type="hidden" value="{{isset(Auth::Guard('member')->user()->id) ? Auth::Guard('member')->user()->id : 0}}" />
        <input id="hidSession" type="hidden" value="{{isset(Auth::Guard('member')->user()->active_session) ? Auth::Guard('member')->user()->active_session : null}}" />
        <input id="hidUsername" type="hidden" value="{{isset(Auth::Guard('member')->user()->username) ? Auth::Guard('member')->user()->username : null}}" />
        <input type="hidden" id="page" value="1" />
        <input type="hidden" id="max_page" value="1" />

            <div class="full-width-tabs">
                <ul class="nav nav-pills">
                    <li class="take-all-space-you-can">
                        <a class="tab" data-toggle="tab" href="#pending-tab" data-status="pending">
                            <div>等待开通
                            </div>
                        </a>
                    </li>              
                
                    <li class="take-all-space-you-can">
                        <a class="tab" data-toggle="tab" href="#verified-tab" data-status="verified">                            
                            <div>
                                开通成功
                            </div>
                        </a>
                    </li>          
                
                    <li class="take-all-space-you-can">
                        <a class="tab" data-toggle="tab" href="#failed-tab" data-status="failed">
                            <div>开通失败
                            </div>
                        </a>
                    </li>          
                </ul>
            </div>
        </div>

        <div id="invitation" class="tab-content">
            <div id="default-tab" class="tab-pane fade in active"></div>
            <div id="pending-tab" class="tab-pane fade"></div>
            <div id="verified-tab" class="tab-pane fade"></div>
            <div id="failed-tab" class="tab-pane fade"></div>
            <p class="isnext">下拉显示更多...</p>
        </div><!-- invitation -->
    </div>
</div>

@endsection

@section('footer-javascript')
    @parent
    <script src="{{ asset('/client/js/round.js') }}"></script>
    <script type="text/javascript">
        var end_of_result = "@lang('dingsu.end_of_result')";
    </script>

@endsection