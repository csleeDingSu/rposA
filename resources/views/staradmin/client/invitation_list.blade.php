@php
    if (env('THISVIPAPP','false')) {
        $default = 'layouts.default_app';
    } else {
        $default = 'layouts.default';
    }
@endphp

@extends($default)

@if(env('THISVIPAPP','false'))
    <!-- top nav -->
    @section('left-menu')
      <a class="returnBtn" href="javascript:history.back();"><img src="{{ asset('clientapp/images/returnIcon.png') }}"><span>返回</span></a>
    @endsection

    @section('title', '邀请记录')

    @section('right-menu')
    @endsection
    <!-- top nav end-->

@else
    @section('title', '邀请记录')

    @section('left-menu')
        <a href="javascript:history.back()" class="back">
            <img src="{{ asset('/client/images/back.png') }}" width="11" height="20" />&nbsp;返回
        </a>
    @endsection
@endif


@section('top-css')
    @parent
	<link rel="stylesheet" href="{{ asset('/client/css/invitation_list.css') }}" />
@endsection

@section('top-javascript')
    @parent
    <!-- <script src="{{ asset('/client/ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js') }}"></script> -->
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
        <div class="information-table">
            <div class="col-xs-12">
                <div class="image-wrapper">
                    <img src="{{ asset('/client/images/summary_bg.png') }}" alt="summary background">
                    <div class="summary-table">                        
                        <div id="total-invite" class="number">&nbsp;</div>
                        <a href="/invitation_list">
                            <div class="description">您已累计邀请人次</div>
                        </a>
                        <a href="/share"><div class="btn-invite">马上邀请</div></a>
                    </div>
                </div>
            </div>

            <div class="full-width-tabs">
                <ul class="nav nav-pills">
                    <li class="take-all-space-you-can active">
                        <a class="tab" data-toggle="tab" href="#my-lvl-invitation" data-status="my-lvl-invitation" id="my-lvl">
                            <div class="lbl-my-lvl-total-invitation">我的邀请 <span id="my-lvl-total-invitation" class="lvl-total-invitation">(0)</span>
                            </div>
                        </a>                        
                    </li>              
                
                    <li class="take-all-space-you-can">
                        <a class="tab" data-toggle="tab" href="#next-lvl-invitation" data-status="next-lvl-invitation" id ="next-lvl">
                            <div class="lbl-next-lvl-total-invitation">下级邀请 <span id="next-lvl-total-invitation" class="lvl-total-invitation">(0)</span></div>
                        </a>                        
                    </li>          
                </ul>
            </div>
        </div>

        </div>
        <div class="tab-content">
            <div id="my-lvl-invitation" class="tab-pane fade in active">
                <div class="full-width-tabs">
                <!-- close
                    <ul class="nav nav-pills">                        
                        <li class="take-all-space-you-can">
                            <a class="tab" data-toggle="tab" href="#pending-tab" data-status="pending">
                                <div>未微信认证
                                <span id="total-pending" class="total-pending">&nbsp;</span>
                                </div>
                            </a>
                        </li>              
                    
                        <li class="take-all-space-you-can">
                            <a class="tab" data-toggle="tab" href="#verified-tab" data-status="verified">
                                
                                <div>
                                    认证成功<span id="total-successful" class="total-successful">&nbsp;</span>
                                </div>
                            </a>
                        </li>          
                    
                        <li class="take-all-space-you-can">
                            <a class="tab" data-toggle="tab" href="#failed-tab" data-status="failed">
                                <div>认证失败
                                <span id="total-fail" class="total-fail">&nbsp;</span>
                                </div>
                            </a>
                        </li>          
                    </ul>
                -->
                    <div id="invitation" class="tab-content">
                        <div id="default-tab" class="tab-pane fade in active"></div>
                        <!-- <div id="pending-tab" class="tab-pane fade"></div>
                        <div id="verified-tab" class="tab-pane fade"></div>
                        <div id="failed-tab" class="tab-pane fade"></div> -->
                        <!-- <p class="isnext">下拉显示更多...</p> -->
                    </div><!-- invitation -->
                </div>
            </div>

            <div id="next-lvl-invitation" class="tab-pane fade">
                <div class="full-width-tabs">
                <!-- close
                    <ul class="nav nav-pills">
                        <li class="take-all-space-you-can">
                            <a class="tab" data-toggle="tab" href="#next-lvl-pending-tab" data-status="next-lvl-pending">
                                <div>未微信认证
                                <span id="next-lvl-total-pending" class="total-pending">&nbsp;</span>
                                </div>
                            </a>
                        </li>              
                    
                        <li class="take-all-space-you-can">
                            <a class="tab" data-toggle="tab" href="#next-lvl-verified-tab" data-status="next-lvl-verified">
                                
                                <div>
                                    认证成功<span id="next-lvl-total-successful" class="total-successful">&nbsp;</span>
                                </div>
                            </a>
                        </li>          
                    
                        <li class="take-all-space-you-can">
                            <a class="tab" data-toggle="tab" href="#next-lvl-failed-tab" data-status="next-lvl-failed">
                                <div>认证失败
                                <span id="next-lvl-total-fail" class="total-fail">&nbsp;</span>
                                </div>
                            </a>
                        </li>          
                    </ul>
                -->

                    <div id="invitation_next_lvl" class="tab-content">
                        <div id="next-lvl-default-tab" class="tab-pane fade in active"></div>
                        <!-- <div id="next-lvl-pending-tab" class="tab-pane fade"></div>
                        <div id="next-lvl-verified-tab" class="tab-pane fade"></div>
                        <div id="next-lvl-failed-tab" class="tab-pane fade"></div>
                         -->
                         <!-- <p class="isnext">下拉显示更多...</p> -->
                    </div>                    
                </div>
                <!-- next-lvl-invitation -->
            </div>
        </div>
    </div>
</div>

@endsection

@section('footer-javascript')
    @parent
    <script src="{{ asset('/client/js/invitation.js') }}"></script>
    <script type="text/javascript">
        var end_of_result = "@lang('dingsu.end_of_result')";
    </script>

    <!-- add next lvl invitation -->
    <script>        
        $(document).ready(function(){            
            // document.getElementById('my-lvl-invitation').style.display = "none";
            // document.getElementById('next-lvl-invitation').style.display = "none";
            // document.getElementById('invitation').style.display = "none";
            // document.getElementById('invitation_next_lvl').style.display = "none";
        })
        
    </script>

@endsection