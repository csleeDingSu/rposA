; (function ($, window) {
    var defaults = {
        maxShowNum: 4,
        expires: 7,
        input: '.history-input',
        cookieName: 'searchHistory',
        selected: function () { },
        beforeSend: function () { return true; },
        sendWhenSelect: true,
        actionByCall:false
    };
    $.fn.searchHistory = function (customOptions) {
        var form = this;
        if (typeof customOptions == 'string') {
            switch (customOptions) {
                case 'close':
                    _close(form[0]);
                    break;
                case 'open':
                    _open(form[0]);
                    break;
                case 'clear':
                    _clear(form[0]);
                    break;
            }
            return form;
        }

        var options = $.extend({}, defaults, customOptions);
        if (form.length > 1)
            return null;
        if (form.length==0)
            return null;
        
        form.$input = form.find(options.input);
        if (form.$input.length > 1)
            return null;
        var $history = $('<div class="search-history search-history-hide"></div>');
        var $list = $('<ul class="history-list"></ul>');
        var $item = $('<li class="history-item"></li>');
        var $clear = $('<li class="history-clear"><span class="search-title">搜索记录</span><a href="#" class="history-clear-op">删除</a></li>');
        var strCookie = $.cookie(options.cookieName);
        form.cookies = []
        if (strCookie && strCookie != 'null')
            $.each(strCookie.split('&'), function (index, value) {
                form.cookies.push(unescape(value));
            });
        for (var i = 0; i < form.cookies.length; i++)
            $list.append($item.clone().html(form.cookies[i]));
        $list.prepend($clear);
        $history.append($list);
        
        //dom_form
        form[0].$history = $history;
        form[0].$list = $list;
        form[0].$clear = $clear;
        form[0].options = options;
        //form.$input form.cookies

        $history.insertAfter(form.$input);

        options.actionByCall || form.$input.click(function (e) {
            e.preventDefault();
            e.stopPropagation();
            if ($list.find('.history-item').length > 0)
                _open(form[0]);
        });
        
        $(window).click(function (e) {
            var source = e.target;
            if (form.has(source).length == 0) {
                _close(form[0]);
            }
        });
        
        $history.data('fromitem', false);
        form.submit(function () {
            var newCookie = $.trim(form.$input.val());
            var index = form.cookies.indexOf(newCookie);
            var len = form.cookies.length;
            if (index == -1)
                len = form.cookies.unshift(newCookie);
            else {
                var temp = form.cookies[index];
                for (var i = index; i > 0; i--)
                    form.cookies[i] = form.cookies[i - 1];
                form.cookies[0] = temp;
            }                
            var tempCookie = (len > options.maxShowNum)?form.cookies.slice(0, options.maxShowNum):form.cookies;
            $.each(tempCookie, function (index, value) {
                tempCookie[index] = escape(value);
            });
            $.cookie(options.cookieName, tempCookie.join('&'), { expires: options.expires, path: '/' });
            
            typeof options.selected == 'function' && options.selected($.trim(form.$input.val()));
                       
            if ((!options.sendWhenSelect) && $history.data('fromitem')) {
                _close(form[0]);
                $history.data('fromitem', false);
                return false;
            }
            
            if (typeof options.beforeSend == 'function')
                return options.beforeSend($.trim(form.$input.val()));

            return true;
        });
        
        $clear.find('.history-clear-op').click(function (e) {
            e.preventDefault();
            e.stopPropagation();
            _clear(form[0]);           
        });
        
        $list.find('.history-item').click(function (e) {
            e.preventDefault();
            e.stopPropagation();
            form.$input.val($.trim($(this).html()));
            typeof options.selected == 'function' && options.selected($.trim(form.$input.val()));
            _close(form[0]);
            form.$input.focus();
            if(options.sendWhenSelect)
                form.submit();            
        });
        
        $history.data('index', -1);
        form.$input.keyup({
            '$input': form.$input,
            '$history': $history,
            '$list': $list.find('.history-item'), 
            'index': $history.data('index')
        }, function (e) {
            var data = e.data;
            var code = e.keyCode ? e.keyCode : e.which;
            
            if ((code === 40 || code === 38) && data.$history.hasClass('search-history-show')) {
                var len = data.$list.length,
                    next,
                    prev;
                
                if (data.index === -1)
                    data.$history.data('original', $.trim(data.$input.val()));
                
                if (len) {
                    if (len > 1) {
                        if (data.index === len - 1) {
                            next = -1;
                            prev = data.index - 1;
                        } else if (data.index === 0) {
                            next = data.index + 1;
                            prev = -1;
                        } else if (data.index === -1) {
                            next = 0;
                            prev = len - 1;
                        } else {
                            next = data.index + 1;
                            prev = data.index - 1;
                        }
                    } else if (data.index === -1) {
                        next = 0;
                        prev = 0;
                    } else {
                        prev = -1;
                        next = -1;
                    }
                    data.index = (code === 40) ? next : prev;

                    data.$list.removeClass("history-item-selected");
                    if (data.index !== -1) {
                        data.$input.val(data.$list.eq(data.index).addClass("history-item-selected").html());
                        data.$history.data('fromitem', true);
                    }
                    else
                        data.$input.val(data.$history.data('original'));
                    data.$history.data('index', data.index);                     
                }
            } 
        });

        function _open(dom_form) {
            if (dom_form.$list.find('.history-item').length > 0)
                dom_form.$history.addClass('search-history-show').removeClass('search-history-hide');
        }
        
        function _close(dom_form) {
            dom_form.$history.addClass('search-history-hide').removeClass('search-history-show');
        }

        function _clear(dom_form) {
            $.cookie(dom_form.options.cookieName, null);
            form.cookies = [];
            dom_form.$list.find('.history-item').remove();
            _close(form[0]);
        }
        return form;
    }
})(jQuery, window);
