@extends('layouts.default')

@section('title', '邀请记录')

@section('left-menu')
    <a href="/profile" class="back">
        <div class="icon-back glyphicon glyphicon-menu-left" aria-hidden="true"></div>
    </a>
@endsection

@section('top-css')
    @parent
	<link rel="stylesheet" href="{{ asset('/client/css/invitation_list.css') }}" />
@endsection

@section('content')
<div class="full-height">
    <div class="container">
        <input id="hidUserId" type="hidden" value="{{isset(Auth::Guard('member')->user()->id) ? Auth::Guard('member')->user()->id : 0}}" />
        <input id="hidSession" type="hidden" value="{{isset(Auth::Guard('member')->user()->active_session) ? Auth::Guard('member')->user()->active_session : null}}" />
        <input id="hidUsername" type="hidden" value="{{isset(Auth::Guard('member')->user()->username) ? Auth::Guard('member')->user()->username : null}}" />
        <div class="information-table">
            <div class="col-xs-12">
                <div class="image-wrapper">
                    <img src="{{ asset('/client/images/summary_bg.png') }}" alt="summary background">
                    <div class="summary-table">
                        <div id="total-invite" class="number">&nbsp;</div>
                        <div class="description">您已累计邀请人次</div>
                        <a href="/share"><div class="btn-invite">马上邀请</div></a>
                    </div>
                </div>
            </div>
              <div class="col-xs-4">
                <div id="total-pending" class="total-pending">&nbsp;</div>
                <div class="total-pending">等待验证</div>
              </div>
              <div class="col-xs-4">
                <div id="total-successful">&nbsp;</div>
                <div>验证成功</div>
              </div>
              <div class="col-xs-4">
                <div id="total-fail">&nbsp;</div>
                <div>验证失败</div>
              </div>
        </div>

        <div id="invitation">

        @if ($invitation_list->isEmpty())

            <div class="row">
                <div class="col-xs-12">
                    <div class="empty">对不起 - 你现在还没有数据。</div>
                </div>
            </div>

        @else

            @foreach ($invitation_list as $l)
            <div class="row">
                <div class="col-xs-8 column-1">
                    <div class="item">{{ $l->username }}</div>
                    <div class="date">{{ date('Y-m-d H:i', strtotime($l->created_at)) }}</div>
                </div>
                <div class="col-xs-4 column-2">
                    <div class="right-wrapper">
                        <div class="status">
                            @if ($l->wechat_verification_status == 0)
                                <span class="successful">验证成功</span>
                            @elseif ($l->wechat_verification_status == 1)
                                <span class="pending">等待验证</span>
                            @else
                                <span class="fail">验证失败</span>
                            @endif
                        </div>
                        
                        <div style="clear: both"></div>
                        <div class="additional">
                            @if ($l->wechat_verification_status == 0)
                            +1
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

        @endif   

        </div><!-- invitation -->
    </div>
</div>

@endsection

@section('footer-javascript')
    @parent
    <script src="{{ asset('/client/js/invitation.js') }}"></script>

@endsection