$(function () {
    bindBetButton();
    DomeWebController.init();

    var oneMinute = 60 * 1;
    startTimer(oneMinute);

});

function bindBetButton(){

    $('.radio-primary', window.parent.document).click(function(){
        $('.radio-primary', window.parent.document).not(this).find('.radio').removeClass('clicked');
        $('.radio-primary', window.parent.document).not(this).find('.bet-container').hide();

        $(this).find('.bet-container').toggle();
        $(this).find('.radio').toggleClass('clicked');

    });
}

function startTimer(duration) {

    var timer = duration, minutes, seconds;

    setInterval(function () {
        minutes = parseInt(timer / 60, 10);
        seconds = parseInt(timer % 61, 10);

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        $( "#txtCounter" ).html(seconds);

        --timer;

        if (timer < 5) {
            //Lock the selection
            $('.radio-primary', window.parent.document).unbind('click');
            //Get selected option
            var selected = $('div.clicked', window.parent.document).find('input:radio').val();
            console.log(selected);
        }

        if (timer < 0) {
            timer = duration;
            $( "#btnWheel" ).trigger( "click" );

            bindBetButton();
        }
        
    }, 1000);
}

DomeWebController = {
    pool: {
        element: {}
    },
    getEle: function (k) {
        return DomeWebController.pool.element[k];
    },
    setEle: function (k, v) {
        DomeWebController.pool.element[k] = v;
    },
    init: function () {
        var that = DomeWebController;
        that.inits.element();
        that.inits.event();
        that.build();
    },
    inits: {
        element: function () {
            var that = DomeWebController;
            that.setEle("$wheelContainer", $('#wheel_container'));

        },
        event: function () {
            var that = DomeWebController;

        }
    },
    build: function () {
        var that = DomeWebController;
        var result = $('#result').val();

        that.getEle("$wheelContainer").wheelOfFortune({
            'wheelImg': "/client/images/wheel.png",//转轮图片
            'pointerImg': "/client/images/pointer.png",//指针图片
            'buttonImg': "/client/images/button.png",//开始按钮图片
            'wSide': 400,//转轮边长(默认使用图片宽度)
            'pSide': 150,//指针边长(默认使用图片宽度)
            'bSide': 80,//按钮边长(默认使用图片宽度)
            'items': {3: [1, 59], 4: [61, 119], 5: [121, 179], 6: [181, 239], 1: [241, 299], 2: [301, 359]},//奖品角度配置{键:[开始角度,结束角度],键:[开始角度,结束角度],......}
            'pAngle': 270,//指针图片中的指针角度(x轴正值为0度，顺时针旋转 默认0)
            'type': 'w',//旋转指针还是转盘('p'指针 'w'转盘 默认'p')
            'fluctuate': 0.5,//停止位置距角度配置中点的偏移波动范围(0-1 默认0.8)
            'rotateNum': 12,//转多少圈(默认12)
            'duration': 2000,//转一次的持续时间(默认5000)
            'click': function () {
                if(1==1){}
                var key = result;
                that.getEle("$wheelContainer").wheelOfFortune('rotate', key);
            },//点击按钮的回调
            'rotateCallback': function (key) {
                //alert("左:" + key);
            }//转完的回调
        });
    }
};