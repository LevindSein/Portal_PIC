$(document).ready(function() {
    //Fullscreen
    if (navigator.userAgent.match(/Android|webOS|iPhone|iPod|Blackberry/i)) {
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
