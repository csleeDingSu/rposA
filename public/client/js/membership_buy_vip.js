var _qrcode = "<?php Print($qrcode);?>";
var qrcode = new QRCode(document.getElementById("showqr"), {
    text: _qrcode,
    width: 200,
    height: 200,
    colorDark: "#000000",
    colorLight: "#ffffff",
    correctLevel: QRCode.CorrectLevel.H
});

//字体变换
var text = document.querySelector(".txt");
var txt_arr = ["确认过眼神你是我的菜", "这个二维码很特别特别", "充值未到账请联系客服", "充值未成功请重新生成"];
var num = 0;
var timer_txt = setInterval(function () {
    //text.innerText = txt_arr[num];
    num++;
    if (num === 4) {
        num = 0;
    }
}, 1500)

//倒计时
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
    // console.log(minu+":"+secd)
    minu = minu <= 9 ? "0" + minu : minu
    secd = secd <= 9 ? "0" + secd : secd
    minute.innerHTML = minu
    second.innerHTML = secd
    // checkdata();
    if (surplusTimes <= 0) {
        alert("订单已过期,请勿支付,请重新发起订单！");
        window.history.go(-1);
        location.reload();
        clearInterval(countdowns)
    }
}, 1000)

function closeWebPage() {
    var userAgent = navigator.userAgent;
    if (userAgent.indexOf("Firefox") != -1 || userAgent.indexOf("Chrome") != -1) {
        window.location.href = "about:blank";
    } else if (userAgent.indexOf("Android") > -1 || userAgent.indexOf("Linux") > -1) {
        window.opener = null;
        window.open("about:blank", "_self", "").close();
    } else {
        window.pener = null;
        window.open("about:blank", "_self");
        window.close();
    }
}
