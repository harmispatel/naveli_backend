<!-- Vendor JS Files -->
<script src="{{ asset('public/assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ asset('public/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('public/assets/vendor/chart.js/chart.min.js') }}"></script>
<script src="{{ asset('public/assets/vendor/echarts/echarts.min.js') }}"></script>
<script src="{{ asset('public/assets/vendor/quill/quill.min.js') }}"></script>
<script src="{{ asset('public/assets/vendor/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('public/assets/vendor/php-email-form/validate.js') }}"></script>

<!-- Template Main JS File -->
<script src="{{ asset('public/assets/vendor/js/main.js') }}"></script>

{{-- Jquery --}}
<script src="{{ asset('public/assets/admin/js/jquery/jquery.min.js') }}"></script>

{{-- Sweet Alert --}}
<script src="{{ asset('public/assets/vendor/js/sweet-alert.js') }}"></script>

{{-- Data Table --}}
<script src="{{ asset('public/assets/vendor/simple-datatables/simple-datatables.js') }}"></script>

{{-- Jquery UI --}}
<script src="{{ asset('public/assets/vendor/js/jquery-ui.js') }}"></script>

{{-- common --}}
<script src="{{ asset('public/assets/vendor/js/common.js') }}"></script>

<script src="{{ asset('public/assets/vendor/js/datatable.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/assets/vendor/js/datatble.buttons.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/assets/vendor/js/jszips.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/assets/vendor/js/pdfmake.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/assets/vendor/js/vfs_fonts.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/assets/vendor/js/button.html5.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/assets/vendor/js/button.print.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/assets/vendor/js/xlsx.full.min.js') }}"></script>
{{-- <script type="text/javascript" src="http://oss.sheetjs.com/js-xlsx/xlsx.core.min.js"></script> --}}
<script type="text/javascript" src="{{ asset('public/assets/vendor/js/filesaver.js') }}"></script>


<script src="{{ asset('public/assets/vendor/js/toastr.min.js') }}"></script>
{{-- select2 --}}
<script src="{{ asset('public/assets/vendor/js/select2.min.js') }}"></script>

{{-- text-editor --}}
<script src="{{ asset('public/assets/vendor/js/ckeditorr.js') }}"></script>

{{-- daterangepicker --}}
<script type="text/javascript" src="{{ asset('public/assets/vendor/js/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/assets/vendor/js/daterangepicker.min.js') }}"></script>
<script type="text/javascript">

@if(Session::has('message'))
  toastr.options =
  {
  	"closeButton" : true,
  	"progressBar" : true
  }
  		toastr.success("{{ session('message') }}");
  @endif

  @if(Session::has('error'))
  toastr.options =
  {
  	"closeButton" : true,
  	"progressBar" : true
  }
  		toastr.error("{{ session('error') }}");
  @endif

</script>

