
var path = (window.location.pathname).toLowerCase();

if (path.indexOf("vip") >= 0) {
    $('.btn-game-vip').css({'z-index': '2', 'color': '#fff', 'background': '#f2a3c3', 'background-image': 'linear-gradient(to right, #f2a3c3 0%, #a05bcc 100%)'});
    $('.btn-game-normal').css({'z-index': '1', 'color': '#666', 'background': '#e7e7e7'});
} else {
    $('.btn-game-normal').css({'z-index': '2', 'color': '#fff', 'background': '#f2a3c3', 'background-image': 'linear-gradient(to right, #f2a3c3 0%, #a05bcc 100%)'});
    $('.btn-game-vip').css({'z-index': '1', 'color': '#666', 'background': '#e7e7e7'});
}

$('.btn-game-normal').click(function() {
    $('.btn-game-normal').css({'z-index': '2', 'color': '#fff', 'background': '#f2a3c3', 'background-image': 'linear-gradient(to right, #f2a3c3 0%, #a05bcc 100%)'});
    $('.btn-game-vip').css({'z-index': '1', 'color': '#666', 'background': '#e7e7e7'});
    setTimeout(function(){ 
        window.top.location.href = "/arcade";
    }, 500);    
});

$('.btn-game-vip').click(function() {
    $('.btn-game-vip').css({'z-index': '2', 'color': '#fff', 'background': '#f2a3c3', 'background-image': 'linear-gradient(to right, #f2a3c3 0%, #a05bcc 100%)'});
    $('.btn-game-normal').css({'z-index': '1', 'color': '#666', 'background': '#e7e7e7'});
    setTimeout(function(){ 
        window.top.location.href = "/vip";
    }, 500);
});