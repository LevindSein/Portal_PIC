<!DOCTYPE html>
<html dir="ltr">

<head>
    @include('portal.home.header')

    <script src="{{asset('template/assets/libs/jquery/dist/jquery.min.js')}}"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{asset('template/dist/css/style.min.css')}}">

    <!-- Favicon icon -->
    <title>404 | Portal PIC</title>
</head>

<body>
    <div class="main-wrapper">
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Login box.scss -->
        <!-- ============================================================== -->
        <div class="error-box">
            <div class="error-body text-center">
                <h1 class="error-title">403</h1>
                <h3 class="text-uppercase error-subtitle">FORBIDDEN ERROR!</h3>
                <p class="text-muted mt-4 mb-4">YOU DON'T HAVE PERMISSION TO ACCESS ON THIS SERVER.</p>
                <a href="{{url('/')}}" class="btn btn-danger btn-rounded waves-effect waves-light mb-5">Back to home</a> </div>

        </div>
    </div>
    <!-- ============================================================== -->
    <!-- All Required js -->
    <!-- ============================================================== -->
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{asset('template/assets/libs/jquery/dist/jquery.min.js')}}"></script>

    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{asset('template/assets/libs/popper.js/dist/umd/popper.min.js')}}"></script>
    <script src="{{asset('template/assets/libs/bootstrap/dist/js/bootstrap.min.js')}}"></script>
</body>

</html>
