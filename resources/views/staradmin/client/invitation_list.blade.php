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
<div class="container demo">

    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
        @if ($invitation_list->isEmpty())

            <div class="invitation-row">
                <div class="col-xs-12">
                    <div class="empty">对不起 - 你现在还没有数据。</div>
                </div>
            </div>

        @else

            @foreach ($invitation_list as $l)
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="heading-{{ $l->id }}">
                    <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $l->id }}" aria-expanded="true" aria-controls="collapse{{ $l->id }}">
                            <!-- <i class="more-less glyphicon glyphicon-menu-right"></i> -->
                            @if ($l->wechat_verification_status == 0)
                                <span style="color: green; float: right; font-weight: 600;">已认证 挖宝次数+1</span>
                            @elseif ($l->wechat_verification_status == 1)
                                <span style="color: blue; float: right; font-weight: 600;">等待认证</span>
                            @else
                                <span style="color: red; float: right; font-weight: 600;">认证失败</span>
                            @endif
                            
                            <div class="invitation-title">{{ $l->username }} 
                            </div>

                        </a>
                    </h4>
                </div>
                <div id="collapse{{ $l->id }}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-{{ $l->id }}">
                    <div class="panel-body">
                        用户名: {{ $l->username }}，
                        电话: {{ str_pad(substr($l->phone, 0, (strlen($l->phone) - 3)), strlen($l->phone), '*', STR_PAD_RIGHT) }}，
                        微信: {{ $l->wechat_name }}
                    </div>
                </div>
            </div>
            @endforeach

        @endif
        
    </div><!-- panel-group -->
    
    
</div><!-- container -->

@endsection


@section('footer-javascript')
	@parent

	<script type="text/javascript">		
		function toggleIcon(e) {
		    $(e.target)
		        .prev('.panel-heading')
		        .find(".more-less")
		        .toggleClass('glyphicon-menu-right glyphicon-menu-down');
		}
		$('.panel-group').on('hidden.bs.collapse', toggleIcon);
		$('.panel-group').on('shown.bs.collapse', toggleIcon);
	</script>
@endsection