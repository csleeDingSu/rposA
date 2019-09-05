
$('.btn-game-normal').click(function() {
    $('.btn-game-normal').attr("z-index", '2');
    $('.btn-game-vip').attr("z-index", '1');
    window.top.location.href = "/arcade";
});
$('.btn-game-vip').click(function() {
    $('.btn-game-normal').attr("z-index", '1');
    $('.btn-game-vip').attr("z-index", '2');
    window.top.location.href = "/vip";
});