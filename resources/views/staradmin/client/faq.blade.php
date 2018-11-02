@extends('layouts.default')

@section('title', '常见问题')

@section('left-menu')
    <a href="/profile" class="back">
        <div class="icon-back glyphicon glyphicon-menu-left" aria-hidden="true"></div>
    </a>
@endsection

@section('top-css')
    @parent
	<link rel="stylesheet" href="{{ asset('/client/css/faq.css') }}" />
@endsection

@section('content')
<div class="container demo">

    
    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        <i class="more-less glyphicon glyphicon-menu-right"></i>
                        <div class="title">如何快速挖宝</div>
                    </a>
                </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                <div class="panel-body">
                      注册用户需先提交实名认证申请，获得认证通过后可参与挖宝活动，新用户拥有获得3次挖宝机会，分享给好友1次可以获得3次挖宝机会，分享越多，挖宝机会越多。
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingTwo">
                <h4 class="panel-title">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        <i class="more-less glyphicon glyphicon-menu-right"></i>
                        <div class="title">邀请好友，有什么好处？</div>
                    </a>
                </h4>
            </div>
            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                <div class="panel-body">
                    注册用户需先提交实名认证申请，获得认证通过后可参与挖宝活动，新用户拥有获得3次挖宝机会，分享给好友1次可以获得3次挖宝机会，分享越多，挖宝机会越多。
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingThree">
                <h4 class="panel-title">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        <i class="more-less glyphicon glyphicon-menu-right"></i>
                        <div class="title">网站的产品不想花钱怎么得到？</div>
                    </a>
                </h4>
            </div>
            <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                <div class="panel-body">
                    注册用户需先提交实名认证申请，获得认证通过后可参与挖宝活动，新用户拥有获得3次挖宝机会，分享给好友1次可以获得3次挖宝机会，分享越多，挖宝机会越多。
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingFour">
                <h4 class="panel-title">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                        <i class="more-less glyphicon glyphicon-menu-right"></i>
                        <div class="title">如何成为VIP</div>
                    </a>
                </h4>
            </div>
            <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
                <div class="panel-body">
                    注册用户需先提交实名认证申请，获得认证通过后可参与挖宝活动，新用户拥有获得3次挖宝机会，分享给好友1次可以获得3次挖宝机会，分享越多，挖宝机会越多。
                </div>
            </div>
        </div>

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