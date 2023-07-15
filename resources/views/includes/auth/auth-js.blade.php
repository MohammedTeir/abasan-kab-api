
<script src="{{asset('assets/js/jquery-3.6.0.min.js')}}"></script>

<script src="{{asset('assets/js/feather.min.js')}}"></script>

<script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>

<script src="{{asset('assets/js/script.js')}}"></script>

<script src="{{ asset('assets/plugins/axios/axios.min.js') }}"></script>
<script src="{{ asset('assets/js/crud.js') }}"></script>

<script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>

<script>


toastr.options = {
  "closeButton": true,
  "newestOnTop": false,
  "progressBar": true,
  "preventDuplicates": false,
  "onclick": null,
  "showDuration": "300",
  "hideDuration": "1000",
  "timeOut": "5000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
}

</script>
 <!--begin::Custom Javascript(used for this page only)-->

 @yield('js-ext')

 <!--end::Vendors Javascript-->
