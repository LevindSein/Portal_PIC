<script>
    @if(Session::has('success'))
    toastr.options = {
        "closeButton": true,
        "preventDuplicates": true,
          "progressBar" : true
    };
    toastr.success("{{ session('success') }}");
    @endif

    @if(Session::has('error'))
    toastr.options = {
        "closeButton": true,
        "preventDuplicates": true,
          "progressBar" : true
    };
    toastr.error("{{ session('error') }}");
    @endif

    @if(Session::has('info'))
    toastr.options = {
        "closeButton": true,
        "preventDuplicates": true,
          "progressBar" : true
    };
    toastr.info("{{ session('info') }}");
    @endif

    @if(Session::has('warning'))
    toastr.options = {
        "closeButton": true,
        "preventDuplicates": true,
          "progressBar" : true
    };
    toastr.warning("{{ session('warning') }}");
    @endif

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            toastr.error("{{ $error }}");
        @endforeach
    @endif
</script>
