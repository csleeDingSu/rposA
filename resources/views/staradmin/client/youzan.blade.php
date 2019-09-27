@php
    if (env('THISVIPAPP','false')) {
        $default = 'layouts.default_app';
    } else {
        $default = 'layouts.default';
    }
@endphp

@extends($default)

@section('top-css')
    @parent
    <link rel="stylesheet" href="{{ asset('/client/css/flickity.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/client/css/productv2_detail.css') }}" />
    <link rel="stylesheet" href="{{ asset('/client/fontawesome-free-5.5.0-web/css/all.css') }}" >
        
@endsection

@section('top-navbar')
@endsection


@section('content')

@if(env('THISVIPAPP','false'))
    <div>
@else
    <div class="container demo">
@endif

        <div class="header_pr header_goods ">
            <header class="icon_header">
                <a href="javascript:history.back()" class="iconfont fa fa-angle-left fa-2x" aria-hidden="true"></a>
            </header>   
        </div>
        <div id="content-window">
            
            <object id="wabaoyouzan"   type="text/html" data="https://detail.youzan.com/show/goods?alias=35vlw7nx488d0&from=wxd&kdtfrom=wxd&alias=35vlw7nx488d0"></object>

        </div>

        

   
    
    
</div><!-- container -->

@endsection




<script type="text/javascript">

        function loadHtml() {
            document.getElementById("content-window").innerHTML='<object id="wabaoyouzan"   type="text/html" data="https://detail.youzan.com/show/goods?alias=35vlw7nx488d0&from=wxd&kdtfrom=wxd&alias=35vlw7nx488d0"></object>';
        }
        //loadHtml();
    </script>

    <style type="text/css">        
        #wabaoyouzan{
            position: absolute;
            width:100%;
            height: 100%;
            display:flex;
            flex-direction: column;
        }
        .header_pr
        {
            margin-top: 10%;
        }
    </style>
