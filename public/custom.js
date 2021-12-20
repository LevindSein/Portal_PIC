$(document).ready(function() {
    //Fullscreen
    if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
        window.scrollTo(0,0); // reset in case prev not scrolled
        var nPageH = $(document).height();
        var nViewH = window.outerHeight;
        if (nViewH > nPageH) {
            nViewH -= 250;
            $('BODY').css('height',nViewH + 'px');
        }
        window.scrollTo(0,1);
    }

    //Maintain Scroll Position
    window.addEventListener('scroll',function() {
        //When scroll change, you save it on localStorage.
        localStorage.setItem('scrollPosition',window.scrollY);
    },false);

    window.addEventListener('load',function() {
        if(localStorage.getItem('scrollPosition') !== null)
            window.scrollTo(0, localStorage.getItem('scrollPosition'));
    },false);
});

$(".number").on('input', function (e) {
    if(e.which >= 37 && e.which <= 40) return;

    if (/^[0-9.,]+$/.test($(this).val())) {
        $(this).val(parseFloat($(this).val().replace(/\./g, '')).toLocaleString('id-ID'));
    }
    else {
        $(this).val($(this).val().substring(0, $(this).val().length - 1));
    }
});

$('.percent').on('input', function (e) {
    if ($(this).val() > 100) $(this).val($(this).val().replace($(this).val(), 100));
});
$('.hour').on('input', function (e) {
    if ($(this).val() > 24) $(this).val($(this).val().replace($(this).val(), 24));
});
