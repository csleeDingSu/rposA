@extends('layouts.default')

@section('title', '联系客服')

@section('left-menu')
    <a href="/profile" class="back">
        <div class="icon-back glyphicon glyphicon-menu-left" aria-hidden="true"></div>
    </a>
@endsection

@section('top-css')
    @parent
	<link rel="stylesheet" href="{{ asset('/client/css/customer_service.css') }}" />
@endsection

@section('content')
<div class="container demo">

    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-title">
            <h1>请加客服微信</h1>
        </div>
        <div class="modal-content modal-wechat">
            <div class="modal-body">                
                <div class="modal-row">
                    <div class="wrapper modal-full-height">
                        <div class="modal-card">
                            <div class="instructions">
                                客服微信在线时间：早上8点-晚上9点
                            </div>                              
                        </div>
                        <div class="row">
                            <div id="cut" class="copyvoucher">{{env('wechat_id', 'BCKACOM')}}</div>
                            <div class="cutBtn">一键复制</div>
                        </div>
                        <div class="modal-card">
                            <div class="instructions-dark">
                                请按复制按钮，复制成功后到微信添加。<br />
                                如复制不成功，请到微信手动输入添加。
                            </div>                              
                        </div>
                    </div>
                </div>                          
            </div>
        </div>
    </div>
    
</div><!-- container -->

@endsection

@section('footer-javascript')
    @parent
    
    <script src="{{ asset('/test/main/js/clipboard.min.js') }}" ></script>
    <script type="text/javascript">
        $(document).ready(function () {
    
            var clipboard = new ClipboardJS('.cutBtn', {
                target: function () {
                    return document.querySelector('#cut');
                }
            });
            clipboard.on('success', function (e) {
                $('.cutBtn').addClass('cutBtn-success').html('<i class="far fa-check-circle"></i>复制成功');
            });

            clipboard.on('error', function (e) {
                // $('.cutBtn').addClass('cutBtn-fail').html('<i class="far fa-times-circle"></i>复制失败');
                $('.cutBtn').addClass('cutBtn-success').html('<i class="far fa-check-circle"></i>复制成功');
            });

        }); 
    </script>
@endsection