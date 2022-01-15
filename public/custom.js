$(document).ready(function() {
    //Maintain Scroll Position
    window.addEventListener('scroll',function() {
        //When scroll change, you save it on localStorage.
        localStorage.setItem('scrollPosition',window.scrollY);
    },false);

    window.addEventListener('load',function() {
        if(localStorage.getItem('scrollPosition') !== null)
            window.scrollTo(0, localStorage.getItem('scrollPosition'));
    },false);

    // $('[data-toggle=tooltip]').tooltip({ trigger: "hover" });
});

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

setInterval(function(){
    var xhttp= new XMLHttpRequest();
    try{
        xhttp.onreadystatechange = function() {
            if (xhttp.readyState == 4 && xhttp.status == 0) {
                alert("Koneksi terputus.");
            }
        };
        xhttp.open("GET", "/tester", true);
        xhttp.send();
    }catch(e){
        console.log('catch', e);
    }
}, 60000);

$(".sidebartoggler").click(function(){
    var adjust = setInterval(() => {
        $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
    }, 10);
    setTimeout(() => {
        clearInterval(adjust);
    }, 1000);
});

setInterval(() => {
    var email = localStorage.getItem("email");
    if(email == 'terverifikasi'){
        localStorage.setItem("email", null);
        location.reload();
    }
}, 60000);

$(".number").on('input keydown', function (e) {
    if(e.which >= 37 && e.which <= 40) e.preventDefault();

    if (/^[0-9\.]+$/.test($(this).val())) {
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

$(".float").on('input keydown', function (e) {
    if(e.which >= 37 && e.which <= 40) e.preventDefault();

    if (/^[0-9\.]+$/.test($(this).val())) {
        $(this).val(parseFloat($(this).val().replace(/\./g, '')).toLocaleString('id-ID'));
    }
    else {
        if (
            (e.keyCode >= 48 && e.keyCode <= 57) ||
            (e.keyCode >= 96 && e.keyCode <= 105) ||
            e.keyCode == 8 || e.keyCode == 9 || e.keyCode == 188) {
            $(this).val($(this).val().substring(0, $(this).val().indexOf(',') + 2));
        } else {
            e.preventDefault();
        }
    }

    if($(this).val().indexOf(',') !== -1 && e.keyCode == 188){
        e.preventDefault();
    }
});

$('[type=tel]').on('change', function(e) {
    $(e.target).val($(e.target).val().replace(/[^\d\.]/g, ''))
});

$('[type=tel]').on('keypress', function(e) {
    keys = ['0','1','2','3','4','5','6','7','8','9']
    return keys.indexOf(e.key) > -1
});
