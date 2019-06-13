






















<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="format-detection" content="telephone=no">
    <meta http-equiv="x-rim-auto-match" content="none">
    <title>微信付款</title>
    <script src="https://api.nx908.com/statics/js/jquery.js"></script>
    <script src="https://api.nx908.com/statics/js/qrcode.min.js"></script>
    <script src="https://api.nx908.com/statics/js/clipboard.min.js"></script>
    <script type="text/javascript" src="https://api.nx908.com/statics/js/toastr.min.js"></script>
    <link rel="stylesheet" href="https://api.nx908.com/statics/css/toastr.min.css">
    <style>
        * {
            padding: 0;
            margin: 0;
        }

        a {
            text-decoration: none;
        }

        .clearfix1:after {
            content: '';
            height: 0;
            line-height: 0;
            visibility: hidden;
            display: block;
            clear: both;
        }

        .clearfix1 {
            zoom: 1;
        }

        html, body {
            background-color: #EDEDED;
        }

        .page {
            width: 660px;
            margin: 0 auto 24px;
            background-color: #ffffff;
        }

        .header {
            position: relative;
            text-align: center;
            height: 67px;
            line-height: 67px;
            vertical-align: middle;
            overflow: hidden;
        }

        .header .img {
            width: 26%;
            display: inline-block;
        }

        .header img {
            width: 100%;
            vertical-align: middle;
        }

        .main {
            overflow: hidden;
        }

        .main .money {
            margin: 30px auto;
            height: 21px;
            line-height: 21px;
            color: #ff0000;
            font-size: 38px;
            font-family: HelveticaNeue;
            text-align: center;
        }

        .main .qr {
            position: relative;
            width: 250px;
            height: 250px;
            margin: 0 auto;
            background: url("https://api.nx908.com/statics/wechat/images/box.png") no-repeat;
            background-size: 100% 100%;
            border: 1px solid transparent;
        }

        .main .qr .ok {
            display: none;
            position: absolute;
            top: 26px;
            left: 26px;
            width: 200px;
            height: 200px;
            background: url("https://api.nx908.com/statics/wechat/images/ok.png") no-repeat;
            background-size: 100% 100%;

        }

        .main .qr #showqr {
            width: 200px;
            height: 200px;
            margin: 26px auto;
            /*background: url("images/qr.png") no-repeat;*/
            background-size: 100% 100%;
        }

        .main .qr .time {
            width: 176px;
            height: 28px;
            font-size: 22px;
            font-family: PingFangSC-Regular;
            position: absolute;
            top: -12px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .main .qr .txt {
            color: #999999;
            font-size: 14px;
            width: 150px;
            position: absolute;
            bottom: -6px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .green {
            color: #59BA36;
        }

        .main .order {
            margin: 21px auto 14px;
            text-align: center;
            font-size: 18px;
            color: #999999;
            font-family: PingFangSC-Medium;
        }

        .main .tit {
            margin: 12px auto 12px;
            text-align: center;
            /* font-size: 28px;
             color: #e04646;*/
            font-weight: 800;
            font-family: PingFangSC-Medium;
        }

        .save {
            display: none;
        }

        .main .txt1 {
            letter-spacing: 1px;
            width: 60%;
            padding: 2% 0;
            text-align: center;
            margin: 0 auto 20px;
            color: #ffffff;
            font-size: 22px;
            /*font-weight: bold;*/
            font-family: PingFangSC-Regular;
            background: rgba(91, 189, 106, 1);
            border-radius: 5px;
        }

        .main .footer {
            width: 80%;
            margin: 27px auto 0;
            border-top: 2px solid #dbdbdb;
            padding-top: 12px;
            font-size: 20px;
            color: #000;
        }

        .main .footer div {
            padding-left: 20px;
        }

        .main .footer .tip {
            float: left;
            display: inline-block;
            width: 20px;
            height: 20px;
            background: url("https://api.nx908.com/statics/wechat/images/tip.png") no-repeat;
            background-size: 100% 100%;
        }

        .tip_txt {
            float: left;
            font-size: 20px;
            margin-left: 8px;
            color: #ff0000;
            display: inline-block;
            height: 18px;
            line-height: 18px;
        }

        .main .footer p {
            margin-bottom: 6px;
            padding-left: 20px;
            padding-bottom: 12px;
            border-bottom: 1px dotted #f1f1f1;
        }

        .mob {
            display: none;
        }

        @media (max-width: 640px) {
            @keyframes changeColor {
                0% {
                    color: #d82b1e
                }
                50% {
                    color: #e79739;
                }
                100% {
                    color: #d82b1e
                }
            }
            .jiaocheng {
                animation: changeColor 1s infinite;
            }

            .page {
                width: 100%;
                margin: auto;
                background-color: #EDEDED;
            }

            .header {
                height: 50px;
                line-height: 50px;
            }

            .header .img {
                width: 34%;
            }

            .header .jiaocheng {
                position: absolute;
                display: inline-block;
                top: 3px;
                right: 5%;
            }

            .main .money {
                margin: 15px auto 35px;
            }

            .main .qr .time {
                font-size: 20px;
            }

            .main .order {
                font-size: 15px;
            }

            .main .order .save {
                display: block;
                font-weight: bold;
                font-size: 18px;
                color: #ff0000;
                margin-bottom: 10px;
            }

            .pc {
                display: none;
            }

            .mob {
                display: block;
            }

            .main .txt1 {
                width: 85%;
                padding: 3% 0;
                color: #e04646;
                font-size: 18px;
                margin: 0 auto 10px;
                font-weight: bold;
            }

            .main .txt2 {
               /* color: #59BA36;*/
                background-color: #ffffff;
                font-weight: bold;
            }

            .main .footer {
                margin: 15px auto 0;
                font-size: 15px;
                width: 95%;
            }

            .main .footer div {
                padding-left: 15px;
            }

            .main .footer p {
                margin-bottom: 3px;
                padding-left: 15px;
                padding-bottom: 5px;
            }

            .main .footer .tip {
                width: 18px;
                height: 18px;
            }

            .tip_txt {
                font-size: 18px;
            }
        }


    </style>
<meta name="__hash__" content="dddbc8ce176219321a4f53ddd7ebbc12_19e772b1c532141347d573157b14986a" /></head>
<body>
<div class="header page">
  <span class="img">
      <img src="https://api.nx908.com/statics/wechat/images/logo.png" alt="">
  </span>
    <!--<a class="mob jiaocheng" href="/api/wechatjiaocheng">扫码教程</a>-->
    <a class="mob jiaocheng" href="javascript:;">扫码教程</a>
</div>
<div class="main page">

    <div class="tit">
        <span>请手动在微信输入此金额</span>
    </div>
    <div class="money">
        <span>&yen;</span> <span id="money">1000.91</span><a href="#" id="copy_p" style="position: absolute;margin-left: 10px;background:#E6CAFF;color: red;font-size: 19px;word-break: keep-all;">【复制金额】</a>
    </div>
    <div class="tit">
        <span>微信扫码后输入金额以以上金额为准</span>
    </div>

    <div class="tit">
        <span>如支付金额不符则无法到账谢谢配合</span>
    </div>

    <div class="qr clearfix1">
        <div class="ok"></div>
        <div id="showqr">
        </div>
        <div class="time">
            <div class="minute green">4</div>&nbsp;分&nbsp;<div class="second green">59</div>&nbsp;秒
        </div>
        <div class="txt">
            客官请稍等片刻
        </div>
    </div>
    <div class="order">
        <span class="save">仅可支付一次 重复支付无效</span>
        订单时间：<span id="order"></span>

    </div>

    <div class="txt1">
        <span class="pc">请打开微信扫一扫</span>
        <span class="mob">长按二维码或截屏保存至相册</span>
    </div>
    <div class="txt1 txt2">
        必须3分钟内付款 否则充值无效
    </div>

    <div class="footer">
        <div style="margin-bottom: 18px;overflow: hidden;"><span class="tip"></span><span class="tip_txt">温馨提示</span>
        </div>
        <p>1、请打开微信扫描二维码充值</p>
        <p>2、如无法扫码付款,请重新生成二维码充值</p>
        <p>3、如充值没有到账,请联系在线客服</p>
    </div>
</div>
<style>
    .tanchu {
        background-color: transparent !important;
        box-shadow: none !important;
    }

    .tanchu .layui-layer-content {
        overflow: hidden !important;
    }

    .close {
        position: absolute;
        top: 0;
        right: 0;
        width: 40px;
        height: 40px;
        display: inline-block;
    }
</style>
<div id="tanchu" style="display: none;">
    <img src="https://api.nx908.com/statics/wechat/images/jiaocheng.png" alt="" usemap="#planetmap"
         style="width: 100%;">
    <map name="planetmap" id="planetmap">
    </map>
    <!--<span onclick="layer.closeAll();" class="close"></span>-->
</div>

<script src="https://cdn.bootcss.com/layer/2.3/layer.js"></script>
<script>
    $('.jiaocheng').on('click', function () {
        layer.open({
            title: '',
            // area: ['300px', '700px'],
            area: '85%',
            offset: '30px',
            type: 1,
            closeBtn: 1,
            shadeClose: false,
            scrollbar: false,
            resize: false,
            anim: -1,
            fixed: true,
            skin: 'tanchu',
            content: $('#tanchu')
        })
    })

</script>
</body>
<script>
    var qrcode = new QRCode(document.getElementById("showqr"), {
        text: "wxp://f2f0U94ebkTIJy4fUkeOgxkr6eBWnESuRrRw",
        width: 200,
        height: 200,
        colorDark: "#000000",
        colorLight: "#ffffff",
        correctLevel: QRCode.CorrectLevel.H
    });
</script>
<script>
    /*字体变换*/
    var text = document.querySelector('.txt');
    var txt_arr = ['确认过眼神你是我的菜', '这个二维码很特别特别', '充值未到账请联系客服', '充值未成功请重新生成'];
    var num = 0;
    var timer_txt = setInterval(function () {
        text.innerText = txt_arr[num];
        num++;
        if (num === 4) {
            num = 0;
        }
    }, 1500)

    /*倒计时*/
    var minute = document.querySelector(".minute")
    var second = document.querySelector(".second")
    // 准备
    var countdownMinute = 5 //10分钟倒计时
    var startTimes = new Date() //开始时间
    var endTimes = new Date(startTimes.setMinutes(startTimes.getMinutes() + countdownMinute)) //结束时间
    var curTimes = new Date() //当前时间
    var surplusTimes = endTimes.getTime() / 1000 - curTimes.getTime() / 1000 //结束毫秒-开始毫秒=剩余倒计时间

    // 进入倒计时
    countdowns = window.setInterval(function () {
        surplusTimes--;
        var minu = Math.floor(surplusTimes / 60)
        var secd = Math.round(surplusTimes % 60)
        // console.log(minu+':'+secd)
        minu = minu <= 9 ? '0' + minu : minu
        secd = secd <= 9 ? '0' + secd : secd
        minute.innerHTML = minu
        second.innerHTML = secd
        // checkdata();
        if (surplusTimes <= 0) {
            alert('订单已过期,请勿支付,请重新发起订单！');
            window.history.go(-1);
            location.reload();
            clearInterval(countdowns)
        }
    }, 1000)



    function closeWebPage() {
        var userAgent = navigator.userAgent;
        if (userAgent.indexOf("Firefox") != -1 || userAgent.indexOf("Chrome") != -1) {
            window.location.href = "about:blank";
        } else if (userAgent.indexOf('Android') > -1 || userAgent.indexOf('Linux') > -1) {
            window.opener = null;
            window.open('about:blank', '_self', '').close();
        } else {
            window.pener = null;
            window.open("about:blank", "_self");
            window.close();
        }
    }
</script>
<script type="text/javascript">
    var clipboard = new Clipboard('#copy_p', {
        text: function () {
            return $("#money").text();
        }
    });

    clipboard.on('success', function (e) {

         toastr.success("复制成功,请使用复制金额付款");
    });

    clipboard.on('error', function (e) {
        document.querySelector('#money');
        toastr.warning("复制失败,请手动复制一下");
    });
</script>
</html>