function historyBackWFallback(fallbackUrl) {
    fallbackUrl = fallbackUrl || '/';
    var prevPage = window.location.href;

    window.history.go(-1);

    setTimeout(function(){ 
        if (window.location.href == prevPage) {
            window.location.href = fallbackUrl; 
        }
    }, 500);
}

function goBack() {
  window.history.back();
}
