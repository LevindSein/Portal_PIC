<script>
    $(document).ready(function() {
        $.fn.dataTable.ext.errMode = 'none';
        $('#dtable').on('error.dt', function(e, settings, techNote, message) {
            alert("Datatable system error.");
            console.log( 'An error has been reported by DataTables: ', message);
        });

        // Hide Tooltip after clicked in 500 milliseconds
        $(document).on('click', '[data-toggle="tooltip"]', function(){
            setTimeout(() => {
                $(this).tooltip('hide');
            }, 500);
        });
    });

    $(window).on('load', function() {
        $(".se-pre-con").fadeIn("slow").fadeOut("slow");
    });

    $(document).on('click', '#logout', function(e){
        e.preventDefault();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: '/logout',
            cache: false,
            method: "POST",
            dataType: "json",
            beforeSend:function(){
                $.blockUI({
                    message: '<i class="fas fa-spin fa-spinner"></i>',
                    baseZ: 9999,
                    overlayCSS: {
                        backgroundColor: '#000',
                        opacity: 0.5,
                        cursor: 'wait'
                    },
                    css: {
                        border: 0,
                        padding: 0,
                        backgroundColor: 'transparent'
                    }
                });
            },
            success:function(data)
            {
                if(data.success){
                    location.reload();
                }

                if(data.info){
                    toastr.info(data.info);
                }

                if(data.warning){
                    toastr.warning(data.warning);
                }

                if(data.error){
                    toastr.error(data.error);
                }

                if(data.debug){
                    console.log(data.debug);
                }
            },
            error:function(data){
                toastr.error("System error.");
                console.log(data);
            },
            complete:function(data){
                $.unblockUI();
            }
        });
    });

    setTimeout(() => {
        $.ajax({
            url: '/check',
            cache: false,
            method: "GET",
            dataType: "json",
            success:function(data)
            {
                if(data.logout){
                    location.reload();
                }
            },
            error:function(data){
                console.log(data);
            }
        });
    }, 0);

    $("#content-button").show();

    $(document).ready(function() {
        window.history.pushState(null, "", window.location.href);
        window.onpopstate = function() {
            window.history.pushState(null, "", window.location.href);
        };
    });
</script>
