var page=1;
var pageMy=1;

$('#hidPg').val(page);
$('#hidPgMy').val(pageMy);
$('#hidNextPg').val(page + 1);
$('#hidNextPgMy').val(pageMy + 1);

$(document).ready(function () {  

    getBlogList(page);
    getBlogMyList(pageMy);
    $('#my').css('display','none');  

    $('.btn-all').click(function() {
      // getBlogList(page);
      $('.btn-all').addClass('on');  
      $('#all').css('display','block');
      $('.btn-my').removeClass('on');
      $('#my').css('display','none');  
    });

    $('.btn-my').click(function() {
      // getBlogMyList(pageMy);
      $('.btn-all').removeClass('on');
      $('#all').css('display','none');  
      $('.btn-my').addClass('on');
      $('#my').css('display','block');
    });       
        
    //execute scroll pagination
    being.scrollBottom('.scrolly', '.wfBox', () => {
        
        if ($(".btn-all").hasClass("on")) {
            
            page++;
            console.log('new page ' + page);
            var current_page = parseInt($('#hidPg').val());
            console.log('current page ' + current_page);
            var next_page = parseInt($('#hidNextPg').val());
            console.log('next page ' + next_page);

            if(page == next_page) {
                getBlogList(page);                
            } else {
                console.log('no page ' + page);
            }
      
        } else {
            pageMy++;
            console.log('new page ' + pageMy);
            var current_page = parseInt($('#hidPgMy').val());
            console.log('current page ' + current_page);
            var next_page = parseInt($('#hidNextPgMy').val());
            console.log('next page ' + next_page);

            if(pageMy == next_page) {
                getBlogList(pageMy);                
            } else {
                console.log('no page ' + pageMy);
            }
        }       

    });

});

function getBlogList(page) {

    page = (page > 0 ? page : 1);

    if (page == 1) {
        document.getElementById('loading2').style.visibility="visible";
    }

    $.ajax({
        type: 'GET',
        url: "/blog/list-all?page=" + page, 
        dataType: "json",
        error: function (error) { 
            console.log(error);
            document.getElementById('loading2').style.visibility="hidden";
        },
        success: function(data) {
            
            // console.log(data);
            var records = data.records.data;
            var html = '';
            var html1 = '';
            var html2 = '';
            var isLine1 = true;
            var _photo = null;
            var _phone = null;
            var _uploads = null;
            var _address = null;

            $.each(records, function(i, item) {
                // console.log(JSON.parse(item.uploads));
                isLine1 = ((i + 1) % 2) > 0 ? true : false;
                _uploads = JSON.parse(item.uploads);
                // console.log(_uploads);
                _photo = (_uploads == null) ? '' : (((_uploads != null && _uploads.length > 0) && (_uploads[0] != 'undefined')) ? _uploads[0] : _uploads);    
                _photo = (_photo == '') ? '' : '<div class="imgBox"><img src="' + _photo + '"></div>';
                _phone = item.phone.substring(0,3) + '*****' + item.phone.slice(-4);
                // _phone = item.phone;
                _address = item.address;
                _address = (_address == null) ? _address : ((_address.length > 5) ? _address.substring(0,5) + '...' : _address);
              
                html = '<a href="/blog/detail?id=' + item.id + '">' +
                            '<div class="inBox">' +
                                _photo +
                                '<h2>' + item.content + '</h2>' +
                                '<div class="inDetail">' +
                                    '<p>' + _phone + '</p>' +
                                    '<span>' + _address + '</span>' +
                                '</div>' +
                            '</div>' +
                        '</a>';

                if (isLine1) {
                    html1 += html;
                } else {
                    html2 += html;
                }

            });

            if (html1 == '' && html2 == '' && $('.item-line-1').html() == ''){

                _html = '<div class="no-record">' +
                            '<img src="/clientapp/images/no-record/blog.png">' +
                            '<div>暂无晒单记录</div>' +
                        '</div>';
                
                $('#inList-all').html(_html);

            } else {

                $('.item-line-1').append(html1);
                $('.item-line-2').append(html2);
            
            } 
               
            $('#hidPg').val(page);
            $('#hidNextPg').val(page + 1);
            document.getElementById('loading2').style.visibility="hidden";
        }
    }); // end $.ajax
    
} // end function

function getBlogMyList(pageMy) {

    pageMy = (pageMy > 0 ? pageMy : 1);

    // if (pageMy == 1) {
    //     document.getElementById('loading2').style.visibility="visible";
    // } 

    $.ajax({
        type: 'GET',
        url: "/blog/list-my?page=" + pageMy + "&memberid=" + $('#hidMemberId').val(), 
        dataType: "json",
        error: function (error) { console.log(error);
          // document.getElementById('loading2').style.visibility="hidden";
        },
        success: function(data) {
          
            // console.log(data);
            var records = data.records.data;
            var html = '';
            var html1 = '';
            var html2 = '';
            var isLine1 = true;
            var _photo = null;
            var _phone = null;
            var _uploads = null;
            var _address = null;

            $.each(records, function(i, item) {
              // console.log(JSON.parse(item.uploads));
              isLine1 = ((i + 1) % 2) > 0 ? true : false;
              _uploads = JSON.parse(item.uploads);
              // console.log(_uploads);
              _photo = (_uploads == null) ? '' : (((_uploads != null && _uploads.length > 0) && (_uploads[0] != 'undefined')) ? _uploads[0] : _uploads);    
              _photo = (_photo == '') ? '' : '<div class="imgBox"><img src="' + _photo + '"></div>';
              _phone = item.phone.substring(0,3) + '*****' + item.phone.slice(-4);
              // _phone = item.phone;
              _address = item.address;
              _address = (_address == null) ? _address : ((_address.length > 5) ? _address.substring(0,5) + '...' : _address);
              
              html = '<a href="/blog/detail?id=' + item.id + '">' +
                      '<div class="inBox">' +
                        _photo +
                        '<h2>' + item.content + '</h2>' +
                        '<div class="inDetail">' +
                          '<p>' + _phone + '</p>' +
                          '<span>' + _address + '</span>' +
                        '</div>' +
                      '</div>' +
                      '</a>';

                if (isLine1) {
                  html1 += html;
                } else {
                  html2 += html;
                }

              });

            if (html1 == '' && html2 == '' && $('.item-line-1-my').html() == '')
            {
              _html = '<div class="no-record">' +
                        '<img src="/clientapp/images/no-record/blog.png">' +
                        '<div>暂无晒单记录</div>' +
                      '</div>';
              $('#inList-my').html(_html);

            } else {
                $('.item-line-1-my').append(html1);
                $('.item-line-2-my').append(html2);
            }
          
            $('#hidPgMy').val(pageMy);
            $('#hidNextPgMy').val(pageMy + 1);
            // document.getElementById('loading2').style.visibility="hidden";

        }
    }); // end $.ajax
    
  } // end function