(function (jQuery) {
    var version = "1.0",
        pluginName = "jQuery.wheelOfFortune",
        elePool = {}, elePoolSB = 0, pluginTagName = "wof-tag",
        configPool = {},
        defaultParam = {
            fluctuate: 0.8,
            rotateNum: 12,
            duration: 5000,
            type: 'p',
            pAngle: 0,
            rotateCallback: function () {
            },
            click: function () {
            },
            inRotation: false
        };

    /* private methods ------------------------------------------------------ */

    /**
     * 生成转盘html
     * @param pointer
     */
    function build(pointer) {
        var param = configPool[pointer],
            wheelImg = param['wheelImg'],
            pointerImg = param['pointerImg'],
            buttonImg = param['buttonImg'],
            pSide = param['pSide'],
            wSide = param['wSide'],
            bSide = param['bSide'],
            pOffset = wSide / 2 - pSide / 2,
            bOffset = wSide / 2 - bSide / 2,
            degree = 0;
            
            // get Degree
            if(typeof param['startKey'] == 'undefined'){
            } else {
                startKey = param['startKey'];
                item = param['items'][startKey],
                start = item[0], end = item[1],
                distance = end - start,
                fluctuate = (1 - param['fluctuate']) * distance / 2,
                target = start + ran(distance - fluctuate * 2) + fluctuate;
                degree = 360 - target + param['pAngle'];

                lastBet = param['lastBet'];

                if(lastBet === 'odd') {
                    cls_odd = '+';
                    cls_even = '-';
                } else {
                    cls_odd = '-';
                    cls_even = '+';
                }

                cls_odd = '';
                cls_even = '';
            }

        var html =
                    '<div class="small-border g6" style="transform: rotate('+ degree +'deg);" w>' +

                        '<div class="shan">' +
                            '<span class="span-odd"><span class="odd-sign">'+ cls_odd +'</span><span class="odd-payout">0</span></span>' +
                            '<div class="div-odd"><span class="odd-number">1</span></div>' +
                        '</div>' +

                        '<div class="shan">' +
                            '<span class="span-even"><span class="even-sign">'+ cls_even +'</span><span class="even-payout">0</span></span>' +
                            '<div class="div-even"><span class="even-number">2</span></div>' +
                        '</div>' +

                        '<div class="shan">' +
                            '<span class="span-odd"><span class="odd-sign">'+ cls_odd +'</span><span class="odd-payout">0</span></span>' +
                            '<div class="div-odd"><span class="odd-number">3</span></div>' +
                        '</div>' +

                        '<div class="shan">' +
                            '<span class="span-even"><span class="even-sign">'+ cls_even +'</span><span class="even-payout">0</span></span>' +
                            '<div class="div-even"><span class="even-number">4</span></div>' +
                        '</div>' +
                        
                        '<div class="shan">' +
                            '<span class="span-odd"><span class="odd-sign">'+ cls_odd +'</span><span class="odd-payout">0</span></span>' +
                            '<div class="div-odd"><span class="odd-number">5</span></div>' +
                        '</div>' +

                        '<div class="shan">' +
                            '<span class="span-even"><span class="even-sign">'+ cls_even +'</span><span class="even-payout">0</span></span>' +
                            '<div class="div-even"><span class="even-number">6</span></div>' +
                        '</div>' +
                    '</div>' +
                    '<div id="btnWheel" class="trigger">&nbsp;</div>' +
                    '<img id="btnPointer" src="/client/images/wheel/pointer.png" width="36%" class="middle" b>';

            html += '<script>' +
                    'bindTriggerButton();' +
                    'showProgressBar(false);' +
                    '</script>';
                
        this.html(html);
        this.find("[b]").on('click', click);
    }

    /**
     * 获取转盘索引
     * @param ele
     * @returns {*|jQuery}
     */
    function getPointer(ele) {
        return $(ele).parent('[' + pluginTagName + ']').attr(pluginTagName);
    }

    /**
     * 点击按钮
     * @param e
     */
    function click(e) {
        e.preventDefault();
        var pointer = getPointer(this),
            callback = configPool[pointer]['click'];
        if (configPool[pointer]['inRotation']) {
            return;
        }
        callback();
    }

    /**
     * 旋转转盘
     * @param key
     * @param t
     */
    function rotate(key, t) {
        var pointer = this.attr(pluginTagName),
            config = configPool[pointer],
            item = config['items'][key],
            start = item[0], end = item[1],
            distance = end - start,
            fluctuate = (1 - config['fluctuate']) * distance / 2,
            target = start + ran(distance - fluctuate * 2) + fluctuate,
            type = t || config['type'],
            callback = function () {
                configPool[pointer]['inRotation'] = false;
                config['rotateCallback'](key);
            };

        if (configPool[pointer]['inRotation']) {
            return;
        }
        configPool[pointer]['inRotation'] = true;

        switch (type) {
            case 'w':
                if (this.find("[w]").size() == 0) {
                    build.apply(this, [pointer])
                }
                this.find("[w]").rotate({
                    duration: config['duration'],
                    angle: 0 + config['pAngle'],
                    animateTo: 360 - target + config['rotateNum'] * 360 + config['pAngle'],
                    callback: callback
                });
                break;
            case 'p':
                if (this.find("[p]").size() == 0) {
                    build.apply(this, [pointer])
                }
                this.find("[p]").rotate({
                    duration: config['duration'],
                    angle: 0 - config['pAngle'],
                    animateTo: target + config['rotateNum'] * 360 - config['pAngle'],
                    callback: callback
                });
                break;
        }
    }

    function ran(n) {
        return parseInt(Math.random() * n);
    }

    /* public methods ------------------------------------------------------- */
    var methods = {
        init: function (parameter) {
            var that = this;
            var param = $.extend({}, defaultParam, parameter);
            var pointer = elePoolSB++;
            elePool[pointer] = this;
            configPool[pointer] = param;
            this.attr(pluginTagName, pointer);


            var wImg = new Image(), bImg = new Image(), pImg = new Image();

            wImg.onload = function () {
                wImgLoading = false;
                if (typeof configPool[pointer]['wSide'] === "undefined") {
                    configPool[pointer]['wSide'] = wImg.width;
                }
                if (!wImgLoading && !bImgLoading && !pImgLoading) {
                    build.apply(that, [pointer]);
                }
            };
            bImg.onload = function () {
                bImgLoading = false;
                if (typeof configPool[pointer]['bSide'] === "undefined") {
                    configPool[pointer]['bSide'] = bImg.width;
                }
                if (!wImgLoading && !bImgLoading && !pImgLoading) {
                    build.apply(that, [pointer]);
                }
            };
            pImg.onload = function () {
                pImgLoading = false;
                if (typeof configPool[pointer]['pSide'] === "undefined") {
                    configPool[pointer]['pSide'] = pImg.width;
                }
                if (!wImgLoading && !bImgLoading && !pImgLoading) {
                    build.apply(that, [pointer]);
                }
            };


            var wImgLoading, bImgLoading, pImgLoading;

            if (typeof param.wheelImg !== "undefined") {
                wImgLoading = true;
                wImg.src = param.wheelImg;
            } else {
                wImgLoading = false;
            }

            if (typeof param.buttonImg !== "undefined") {
                bImgLoading = true;
                bImg.src = param.buttonImg;
            } else {
                bImgLoading = false;
            }

            if (typeof param.pointerImg !== "undefined") {
                pImgLoading = true;
                pImg.src = param.pointerImg;
            } else {
                pImgLoading = false;
            }


        },
        rotate: function () {
            rotate.apply(this, arguments);
        },
        version: function () {
            return version;
        },
        ver: function () {
            return version;
        }

    };


    /**
     * <b>初始化</b>
     * $(xxx).wheelOfFortune({
     * 'wheelImg':,//转轮图片
     * 'pointerImg':,//指针图片
     * 'buttonImg':,//开始按钮图片
     * 'wSide':,//转轮边长(默认使用图片宽度)
     * 'pSide':,//指针边长(默认使用图片宽度)
     * 'bSide':,//按钮边长(默认使用图片宽度)
     * 'items':,//奖品角度配置{键:[开始角度,结束角度],键:[开始角度,结束角度],......}
     * 'pAngle':,//指针图片中的指针角度(x轴正值为0度，顺时针旋转 默认0)
     * 'type':,//旋转指针还是转盘('p'指针 'w'转盘 默认'p')
     * 'fluctuate':,//停止位置距角度配置中点的偏移波动范围(0-1 默认0.8)
     * 'rotateNum':,//转多少圈(默认12)
     * 'duration':,//转一次的持续时间(默认5000)
     * 'click':,//点击按钮的回调
     * 'rotateCallback'//转完的回调
     * });
     *
     * <b>转到目标奖项</b>
     * $(xxx).wheelOfFortune('rotate',key,type);
     * 'rotate':调用转方法
     * key:初始化中items的键
     * type:旋转指针还是转盘('p'指针 'w'转盘) 优先于初始化的type
     */
    jQuery.fn.wheelOfFortune = function (method) {
        if (this.size() !== 1) {
            var err_msg = "这个插件(" + pluginName + ")一次只能对一个元素使用;size:" + this.size();
            this.html('<span style="color: red;">' + 'ERROR: ' + err_msg + '</span>');
            $.error(err_msg);
        }
        // Method calling logic
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === "object" || !method) {
            return methods.init.apply(this, arguments);
        } else {
            $.error("方法 " + method + "不存在于" + pluginName);
        }

    };
})(jQuery);