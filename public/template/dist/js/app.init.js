$(function() {
    var sidebarType_cookie = getCookie('sidebarType');
    if(sidebarType_cookie){
        setCookie('sidebarType',sidebarType_cookie,1);
        $("#main-wrapper").AdminSettings({
            Theme: false, // this can be true or false ( true means dark and false means light ),
            Layout: 'vertical',
            LogoBg: 'skin6', // You can change the Value to be skin1/skin2/skin3/skin4/skin5/skin6
            NavbarBg: 'skin1', // You can change the Value to be skin1/skin2/skin3/skin4/skin5/skin6
            SidebarType: sidebarType_cookie, // You can change it full / mini-sidebar / iconbar / overlay
            SidebarColor: 'skin6', // You can change the Value to be skin1/skin2/skin3/skin4/skin5/skin6
            SidebarPosition: true, // it can be true / false ( true means Fixed and false means absolute )
            HeaderPosition: true, // it can be true / false ( true means Fixed and false means absolute )
            BoxedLayout: false, // it can be true / false ( true means Boxed and false means Fluid )
        });
        if(sidebarType_cookie == 'full'){
            $(".menuku").css("padding-left", "1rem");

            $(".left-sidebar").hover(
                function () {
                    $(".menuku").css("padding-left", "1rem");
                },
                function () {
                    $(".menuku").css("padding-left", "1rem");
                }
            );
        }
        else{
            $(".menuku").css("padding-left", "0px");
            $(".left-sidebar").hover(
                function () {
                    $(".menuku").css("padding-left", "1rem");
                },
                function () {
                    $(".menuku").css("padding-left", "0px");
                }
            );
        }
    }
    else{
        setCookie('sidebarType','full',1);
        $("#main-wrapper").AdminSettings({
            Theme: false, // this can be true or false ( true means dark and false means light ),
            Layout: 'vertical',
            LogoBg: 'skin6', // You can change the Value to be skin1/skin2/skin3/skin4/skin5/skin6
            NavbarBg: 'skin1', // You can change the Value to be skin1/skin2/skin3/skin4/skin5/skin6
            SidebarType: 'full', // You can change it full / mini-sidebar / iconbar / overlay
            SidebarColor: 'skin6', // You can change the Value to be skin1/skin2/skin3/skin4/skin5/skin6
            SidebarPosition: true, // it can be true / false ( true means Fixed and false means absolute )
            HeaderPosition: true, // it can be true / false ( true means Fixed and false means absolute )
            BoxedLayout: false, // it can be true / false ( true means Boxed and false means Fluid )
        });
        $(".menuku").css("padding-left", "1rem");

        $(".left-sidebar").hover(
            function () {
                $(".menuku").css("padding-left", "1rem");
            },
            function () {
                $(".menuku").css("padding-left", "1rem");
            }
        );
    }


    $("#sidebarType").click(function(){
        var sidebarType_cookie = getCookie('sidebarType');
        if(sidebarType_cookie == 'full'){
            setCookie('sidebarType','mini-sidebar',1);
            $("#main-wrapper").AdminSettings({
                Theme: false, // this can be true or false ( true means dark and false means light ),
                Layout: 'vertical',
                LogoBg: 'skin6', // You can change the Value to be skin1/skin2/skin3/skin4/skin5/skin6
                NavbarBg: 'skin1', // You can change the Value to be skin1/skin2/skin3/skin4/skin5/skin6
                SidebarType: 'mini-sidebar', // You can change it full / mini-sidebar / iconbar / overlay
                SidebarColor: 'skin6', // You can change the Value to be skin1/skin2/skin3/skin4/skin5/skin6
                SidebarPosition: true, // it can be true / false ( true means Fixed and false means absolute )
                HeaderPosition: true, // it can be true / false ( true means Fixed and false means absolute )
                BoxedLayout: false, // it can be true / false ( true means Boxed and false means Fluid )
            });
            $(".menuku").css("padding-left", "0px");
            $(".left-sidebar").hover(
                function () {
                    $(".menuku").css("padding-left", "1rem");
                },
                function () {
                    $(".menuku").css("padding-left", "0px");
                }
            );
        }
        else{
            setCookie('sidebarType','full',1);
            $("#main-wrapper").AdminSettings({
                Theme: false, // this can be true or false ( true means dark and false means light ),
                Layout: 'vertical',
                LogoBg: 'skin6', // You can change the Value to be skin1/skin2/skin3/skin4/skin5/skin6
                NavbarBg: 'skin1', // You can change the Value to be skin1/skin2/skin3/skin4/skin5/skin6
                SidebarType: 'full', // You can change it full / mini-sidebar / iconbar / overlay
                SidebarColor: 'skin6', // You can change the Value to be skin1/skin2/skin3/skin4/skin5/skin6
                SidebarPosition: true, // it can be true / false ( true means Fixed and false means absolute )
                HeaderPosition: true, // it can be true / false ( true means Fixed and false means absolute )
                BoxedLayout: false, // it can be true / false ( true means Boxed and false means Fluid )
            });
            $(".menuku").css("padding-left", "1rem");
            $(".left-sidebar").hover(
                function () {
                    $(".menuku").css("padding-left", "1rem");
                },
                function () {
                    $(".menuku").css("padding-left", "1rem");
                }
            );
        }
    });

    function setCookie(name,value,days) {
        var expires = "";
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days*24*60*60*1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "")  + expires + "; path=/";
    }
    function getCookie(name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for(var i=0;i < ca.length;i++) {
            var c = ca[i];
            while (c.charAt(0)==' ') c = c.substring(1,c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
        }
        return null;
    }
});
