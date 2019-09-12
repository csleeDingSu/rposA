
$(document).ready(function () {
    getFromTabao();     
});

function getFromTabao(){
    var html = '';
    $.ajax({
        type: 'GET',
        url: "/tabao/test", 
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        error: function (error) {
            console.log(error);
            alert(error.responseText);
            $(".reload").show();
        },
        success: function(data) {
            console.log(data);
            html += '<div class="inBox">' +
            '<div class="imgBox">' +
              '<img src="https://img.alicdn.com/imgextra/i1/4103344049/O1CN01wYyqYz1fmUCm2JWEk_!!4103344049.jpg">' +
            '</div>' +
            '<div class="txtBox flex1">' +
              '<h2 class="name">【第二件0元】海底捞牛油火锅底料</h2>' +
              '<div class="typeBox">' +
                '<span class="type-red">20元</span>' +
                '<span class="type-sred">奖励100积分</span>' +
                '<span class="type-blue">抽奖补贴12元</span>' +
              '</div>' +
              '<div class="moneyBox">' +
                '<p class="icon">¥</p>' +
                '<p class="nowTxt">3.0</p>' +
                '<p class="oldTxt">35.00</p>' +
                '<a href="#" class="btn">' +
                  '<p>热销1.7万</p>' +
                  '<div class="inTxt">' +
                    '<img src="/clientapp/images/shapeIcon.png">' +
                    '<span>去领券</span>' +
                  '</div>' +
                '</a>' +
              '</div>' +
            '</div>' +
          '</div>';

            $('.listBox').html(html);
            
        }
    });
}
