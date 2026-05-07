 <!-- End of Page Wrapper -->

 <!--start back-to-top-->
 <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
     <i class="ri-arrow-up-line"></i>
 </button>
 <!--end back-to-top-->

 <!--preloader-->
 <div id="preloader">
     <div id="status">
         <div class="spinner-border text-primary avatar-sm" role="status">
             <span class="visually-hidden">Loading...</span>
         </div>
     </div>
 </div>

 <script src="{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
 <script src="{{ asset('assets/libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>

 <!-- JAVASCRIPT -->
 <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
 <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
 <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
 <script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
 <script src="{{ asset('assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
 {{--  <script src="{{ asset('assets/js/plugins.js') }}"></script>  --}}
 <!-- prismjs plugin -->
 <script src="{{ asset('assets/libs/prismjs/prism.js') }}"></script>

 <!-- rater-js plugin -->
 {{--  <script src="{{ asset('assets/libs/rater-js/index.js') }}"></script>  --}}
 <!-- rating init -->
 {{--  <script src="{{ asset('assets/js/pages/rating.init.js') }}"></script>  --}}




 <!-- App js -->
 <script src="{{ asset('assets/js/app.js') }}"></script>


 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

 <script>
 document.addEventListener('DOMContentLoaded', function () {
     if (typeof flatpickr === 'undefined') return;

     document.querySelectorAll('input[type="date"]').forEach(function (input) {
         if (input.dataset.fpBound === '1') return;

         input.dataset.fpBound = '1';
         flatpickr(input, {
             dateFormat: 'Y-m-d',
             altInput: true,
             altFormat: 'd-m-Y',
             allowInput: true,
         });
     });
 });
 </script>