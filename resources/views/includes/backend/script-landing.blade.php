  <!-- Vendor JS Files -->
  <script src="{{url("bl/assets/vendor/purecounter/purecounter_vanilla.js")}}"></script>
  <script src="{{url("bl/assets/vendor/aos/aos.js")}}"></script>
  <script src="{{url("bl/assets/vendor/bootstrap/js/bootstrap.bundle.min.js")}}"></script>
  <script src="{{url("bl/assets/vendor/glightbox/js/glightbox.min.js")}}"></script>
  <script src="{{url("bl/assets/vendor/swiper/swiper-bundle.min.js")}}"></script>
  <script src="{{url("bl/assets/vendor/php-email-form/validate.js")}}"></script>

  <!-- Template Main JS File -->
  <script src="{{url("bl/assets/js/main.js")}}"></script>
 
  

@stack('datatable-scripts')
@stack('galleries-scripts')
@stack('timepicker-scripts')
@stack('calendar-scripts')
@stack('todo-scripts')
@stack('carousel-scripts')
@stack('ckeditor-scripts')
@stack('journal-scripts')
<!-- Plugins JS Ends-->
<!-- Theme js-->
<script src='{{url("cuba/assets/js/script.js")}}'></script>
<!-- login js-->
<!-- Plugin used-->

{{-- CUSTOM SCRIPT --}}
@yield('js')