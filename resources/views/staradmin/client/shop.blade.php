@extends('layouts.default_app')

@section('title', '商城')

@section('top-css')
    @parent
    <link rel="stylesheet" href="{{ asset('/clientapp/css/shop.css') }}" />
    <link rel="stylesheet" href="{{ asset('/client/css/productv2.css') }}" />
    <style>
        body {
            background: #8c35d8;
        }
    </style>
@endsection

@section('top-navbar')
@endsection

@section('content')

    <div class="redeem-banner">
        <img src="{{ asset('/clientapp/images/shop/banner.png') }}">
    </div>
    
    <div class="redeem-prize-wrapper"></div>

    <hr class="h36">

@endsection

@section('footer-javascript')
    @parent
    <script src="{{ asset('/clientapp/js/shop.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            var wechat_status = "<?php Print($member->wechat_verification_status);?>";
            var normal_game_point = getNumeric("<?php Print(empty($wallet['gameledger']['102']->point) ? 0 : $wallet['gameledger']['102']->point);?>");
            var current_point = getNumeric("<?php Print(empty($wallet['gameledger']['103']->point) ? 0 : $wallet['gameledger']['103']->point);?>");
            var usedpoint = getNumeric("<?php Print(empty($wallet['gameledger']['102']->used_point) ? 0 : $wallet['gameledger']['102']->used_point);?>");

        });

        function getNumeric(value) {
            // return ((value % 1) > 0) ? Number(parseFloat(value).toFixed(2)) : Number(parseInt(value));
            return parseFloat(value).toFixed(2);
          }

    </script>
@endsection
