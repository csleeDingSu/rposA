var totalNum = 0;
var pageId = 1;
var pageSize = 50;

  $(document).ready(function () {
    if ($('#search').val() != "") {
      console.log('777');
      goSearch(pageId);       
    }

    //execute scroll pagination
    being.scrollBottom('.scrolly', '.listBox', () => {   
      pageId = ($('#hidPageId').val() == '') ? 1 : $('#hidPageId').val();
      console.log('dasdsa - ' + pageId)
      goSearch(pageId);
    }); 
});

  function goSearch(pageId) {
    var search = $('#search').val();
    if (pageId == 'undefined' || pageId == undefined) {
      pageId = 1;
    }

    console.log(search);
    console.log(pageSize);
    console.log(pageId);

      var html = '';

      if (search != "") {
        document.getElementById('loading').style.visibility="visible";
        $.ajax({
            type: 'GET',
            url: "/tabao/list-super-goods?search=" + search + "&pageSize=" + pageSize + "&pageId=" + pageId, 
            contentType: "application/json; charset=utf-8",
            dataType: "text",
            error: function (error) {
                console.log(error);
                alert(error.responseText);
                $(".reload").show();
            },
            success: function(data) {
                document.getElementById('loading').style.visibility="hidden";
                // alert(data == '');
                // alert(jQuery.isEmptyObject(JSON.parse(data)));
                 // console.log(data);
                // console.log(JSON.parse(data).data.list);
                if ((data == '') || (jQuery.isEmptyObject(JSON.parse(data))) || (JSON.parse(data).data.list == undefined) || (JSON.parse(data).data.list == '') || (typeof JSON.parse(data).data.list === 'undefined')){

                  html += '';

                } else {

                  var records = JSON.parse(data).data.list;
                  var newPrice = 0; 
                  var sales = 0;
                  totalNum = JSON.parse(data).data.totalNum;
                  // $('#hidPageId').val(JSON.parse(data).data.pageId);
                  // $('#hidPageId').val(Number(JSON.parse(data).data.pageId) + 1);

                  // pageId = $('#hidPageId').val();
                 
                    $.each(records, function(i, item) {

                      newPrice = getNumeric(Number(item.originalPrice) - Number(item.couponPrice) - Number(12));
                      newPrice = (newPrice > 0) ? newPrice : 0;
                      sales = parseFloat(Number(item.couponTotalNum) / 10000).toFixed(1);
                      console.log(item.couponLink + 'dsad' + i);
                      // return item.couponLink;

                      html += '<div class="inBox">' +
                                '<div class="imgBox">' +
                                  '<img src="'+item.mainPic+'">' +
                                '</div>' +
                                '<div class="txtBox flex1">' +
                                  '<h2 class="name">'+item.title+'</h2>' +
                                  '<div class="typeBox">' +
                                    '<span class="type-red">'+item.couponPrice+'元</span>' +
                                    '<span class="type-sred">奖励100积分</span>' +
                                    '<span class="type-blue">抽奖补贴12元</span>' +
                                  '</div>' +
                                  '<div class="moneyBox">' +
                                    '<p class="icon">¥</p>' +
                                    '<p class="nowTxt">'+ newPrice +'</p>' +
                                    '<p class="oldTxt">'+item.originalPrice+'</p>' +
                                    '<a href="'+item.couponLink+'" class="btn">' +
                                      '<p>热销'+ sales +'万</p>' +
                                      '<div class="inTxt">' +
                                        '<img src="/clientapp/images/shapeIcon.png">' +
                                        '<span>去领券</span>' +
                                      '</div>' +
                                    '</a>' +
                                  '</div>' +
                                '</div>' +
                              '</div>';
                    });
                }                
            
              if (pageId == 1) {

                $('.listBox').html(html); 
              } else {
                $('.listBox').append(html); 
              }

               pageId++;
              $('#hidPageId').val(pageId);
              console.log(pageId);
              // console.log($('#hidPageId').val());


            }
        });  
      
      } else {
        alert('请输入产品');
      }

    }

  function getNumeric(value) {
    return ((value % 1) > 0) ? Number(parseFloat(value).toFixed(2)) : Number(parseInt(value));
  }
