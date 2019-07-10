;(function ($) {
	$.fn.keyboard = function (options) {
		var bodyW = document.documentElement.clientWidth || document.body.clientWidth;
		var itemWidth = (bodyW - 40) / 10;
		var point = $('.span-bet').val();

		var keyBoard = '<div id="keycontent">\n' +
			'<div id="keyboard">\n' +
			'    <div class="keyTitle">\n' +
			'        <div class="keyText"><img src="/client/images/coin.png" /><input id="txt_key" type="text" value="'+ point +'" disabled /></div>\n' +
			'        <div class="keyButton keyAllIn">全投</div>\n' +
			'        <div class="keyButton keyClear">清空</div>\n' +
			'    </div>\n' +
			'    <div class="keyContent"></div>\n' +
			' </div>\n' +
			' <div class="keyMask"></div>\n' +
			'</div>';
		if (!($("#keycontent").length > 0)) {
			$('body').append(keyBoard);
		}
		var defaults = {
			//各种参数、各种属性
			defaults: 'English', //键盘显示类型   English 字母  number 数字
			inputClass: 'text', //输入框ID
			caseSwitch: 'toLowerCase', //英文大小写  toLowerCase 小写  toUpperCase 大写


		};

		var endOptions = $.extend(defaults, options);


		this.each(function () {
			var _this = $('#keycontent');

			caseSwitch(defaults.defaults);


			_this.on('click', 'li', function () { //获取点击的内容
				inputVal($(this));
				keyState($(this));
			});


			_this.on('click', '.caseSwitch', function () { //大小写切换事件
				if (defaults.caseSwitch == 'toLowerCase') {
					defaults.caseSwitch = 'toUpperCase';
				} else if (defaults.caseSwitch == 'toUpperCase') {
					defaults.caseSwitch = 'toLowerCase';
				};
				english(defaults.caseSwitch);
				keyState($(this));
			});

			_this.on('click', '.del', function () { //删除事件
				inputValDel();
				keyState($(this));
			});
			_this.on('click', '.englishSwitch', function () { //数字键盘
				caseSwitch('number');
				keyState($(this));
			});
			_this.on('click', '.complete', function () { //完成
				keyState($(this));
				_this.remove();
			});
			_this.on('click', '.englishKeyboard', function () { //英文键盘
				caseSwitch('English');
				keyState($(this));
			});
			_this.on('click', '.symbolSwitch', function () { //符号键盘
				caseSwitch('symbol');
				keyState($(this));
			});
			_this.on('click', '.numDel', function () { //删除事件
				inputValDel();
				keyState($(this));
			});
			_this.on('click', '.numComplete', function () { //完成
				keyState($(this));
				_this.remove();
			});
			_this.on('click', '.keyHide,.keyMask', function () { //收起键盘
				_this.remove();

			});
			_this.on('click', '.keyClear', function () { //完成
				keyState($(this));
				$('#txt_key').val(0);
				$('.span-bet').val(0);
			});
			_this.on('click', '.keyAllIn', function () { //完成
				keyState($(this));
				var point = $('#hidTotalBalance').val();
				$('#txt_key').val(point);
				$('.span-bet').val(point);
			});


			function inputVal(_this) {
				let oDiv = $('.' + defaults.inputClass + '').val();
				let val = oDiv += _this.html();

				if(isNaN(val)) {
					val = 0;
				}
				val = parseInt(val);

				$('.' + defaults.inputClass + '').val(val);
				$('#txt_key').val(val);
			}

			function inputValDel() {
				let oDiv = $('.' + defaults.inputClass + '').val().toString();
				var val = 0;

				if(oDiv.length > 1){
					val = oDiv.substring(0, oDiv.length - 1);
				}

				if(isNaN(val)) {
					val = 0;
				}
				val = parseInt(val);

				$('.' + defaults.inputClass + '').val(val);
				$('#txt_key').val(val);
			}


			function caseSwitch(data) {
				if (data == 'English') {
					english(defaults.caseSwitch);
				} else if (data == 'number') {
					number();
				} else if (data == 'symbol') {
					symbol();
				}
			}

			function number() { //数字键盘
				_this.find('.keyContent').html('');
				let numberArray = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0'];
				let number = '';
				number += '<ul class="number">';
				for (let i = 0; i < numberArray.length; i++) {

					number += "<li>" + numberArray[i] + "</li>"
				}
				number += '</ul>';
				number += '<div class="numDel">删除</div>';
				number += '<div class="numComplete">確定</div>';
				_this.find('.keyContent').append(number);
			}

			function english(data) { //英文键盘
				_this.find('.keyContent').html('');
				let englishA = ['q', 'w', 'e', 'r', 't', 'y', 'u', 'i', 'o', 'p', 'a', 's', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'z', 'x', 'c', 'v', 'b', 'n', 'm'];
				let english = '';
				let englishArray = [];
				english += '<ul class="english">';
				if (data == 'toUpperCase') {
					for (let i = 0; i < englishA.length; i++) {
						englishArray.push(englishA[i].toUpperCase())
					}

				} else {
					for (let i = 0; i < englishA.length; i++) {
						englishArray.push(englishA[i].toLowerCase())
					}
				}


				for (let i = 0; i < englishArray.length; i++) {
					if (i == 10) {
						english += "<li class='item' style='width: " + itemWidth + "px;margin-left:" + (itemWidth / 2 + 2 * 2) + "px'>" + englishArray[i] + "</li>"
					} else if (i == 19) {
						english += "<li class='item' style='width: " + itemWidth + "px;margin-left:" + (itemWidth + itemWidth / 2 + 2 * 4) + "px'>" + englishArray[i] + "</li>"
					} else {
						english += "<li class='item' style='width: " + itemWidth + "px'>" + englishArray[i] + "</li>"
					}
				}
				english += '</ul>';
				english += '<div class="caseSwitch" style="width: ' + (itemWidth + itemWidth / 2 + 2) + 'px">切换</div>';
				english += '<div class="del" style="width: ' + (itemWidth + itemWidth / 2 + 2) + 'px">删除</div>';
				english += '<div class="bottom">\n' +
					'        <div class="englishSwitch" style="width: ' + ((itemWidth / 2 + 2 * 3) + itemWidth * 2) + 'px">123</div>\n' +
					'        <div class="space">米粒键盘</div>\n' +
					'        <div class="symbolSwitch" style="width: ' + ((itemWidth / 2 + 2 * 3) + itemWidth * 2) + 'px">@#%</div>\n' +
					'    </div>';
				_this.find('.keyContent').append(english);
			}

			function symbol(data) { //符号键盘
				_this.find('.keyContent').html('');
				let symbolArray = ['!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '_', '\'', '"', ',', ';', '.', '?', '/', '\\', '+', '=', '-', '~', '<', '>', '|'];
				let english = '';
				english += '<ul class="english">';

				for (let i = 0; i < symbolArray.length; i++) {
					if (i == 10) {
						english += "<li class='item' style='width: " + itemWidth + "px;margin-left:" + (itemWidth / 2 + 2 * 2) + "px'>" + symbolArray[i] + "</li>"
					} else if (i == 19) {
						english += "<li class='item' style='width: " + itemWidth + "px;margin-left:" + (itemWidth + itemWidth / 2 + 2 * 4) + "px'>" + symbolArray[i] + "</li>"
					} else {
						english += "<li class='item' style='width: " + itemWidth + "px'>" + symbolArray[i] + "</li>"
					}
				}
				english += '</ul>';
				english += '<div class="englishKeyboard" style="width: ' + (itemWidth + itemWidth / 2 + 2) + 'px">ABC</div>';
				english += '<div class="del" style="width: ' + (itemWidth + itemWidth / 2 + 2) + 'px">删除</div>';
				english += '<div class="bottom">\n' +
					'        <div class="englishSwitch" style="width: ' + ((itemWidth / 2 + 2 * 3) + itemWidth * 2) + 'px">123</div>\n' +
					'        <div class="space">米粒键盘</div>\n' +
					'        <div class="complete" style="width: ' + ((itemWidth / 2 + 2 * 3) + itemWidth * 2) + 'px">完成</div>\n' +
					'    </div>';
				_this.find('.keyContent').append(english);
			}

			function keyState(data) {
				data.css('opacity', '0.3')
				setTimeout(function () {
					data.css('opacity', '1')
				}, 100);
			}

		});



	};
})(jQuery);
