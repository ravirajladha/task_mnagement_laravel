	</div>



	<footer class="footer">
	    <div class="container-fluid">
	        <div class="row">
	            <div class="col-sm-6">
	                <script>
	                    document.write(new Date().getFullYear())
	                </script> © Kods Technologies Private Limited
	            </div>
	            <div class="col-sm-6">
	                <div class="text-sm-end d-none d-sm-block">
	                    
	                </div>
	            </div>
	        </div>
	    </div>
	</footer>


	<!-- JAVASCRIPT -->
	<script src="/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="/assets/libs/simplebar/simplebar.min.js"></script>
	<script src="/assets/libs/node-waves/waves.min.js"></script>
	<script src="/assets/libs/feather-icons/feather.min.js"></script>
	<script src="/assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
	<script src="/assets/js/plugins.js"></script>

	<script src="/assets/libs/apexcharts/apexcharts.min.js"></script>

	<!-- projects js -->
	<script src="/assets/js/pages/dashboard-projects.init.js"></script>


	<!-- apexcharts -->
	<script src="/assets/libs/apexcharts/apexcharts.min.js"></script>

	<!-- Vector map-->
	<script src="/assets/libs/jsvectormap/js/jsvectormap.min.js"></script>
	<script src="/assets/libs/jsvectormap/maps/world-merc.js"></script>

	<!--Swiper slider js-->
	<script src="/assets/libs/swiper/swiper-bundle.min.js"></script>

	<!-- Dashboard init -->
	<script src="/assets/js/pages/dashboard-ecommerce.init.js"></script>

	<!-- App js -->
	<script src="/assets/js/app.js"></script>
	
	{{-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> --}}
	
	<script src="/assets/libs/prismjs/prism.js"></script>

	<!-- App js -->
	
	<script type="text/javascript" async src="https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.5/latest.js?config=TeX-MML-AM_CHTML" async>
	</script>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if(!empty(session()->get('failed'))) { ?>
  <script type="text/javascript">
  Swal.fire({
   icon: 'warning',
   title: '{{ session()->get('failed') }}',
   showConfirmButton: false,
   timer: 2000
 })
  </script>
 <?php } session()->forget('failed'); ?>

 
 <?php if(!empty(session()->get('success'))) { ?>
	<script type="text/javascript">
	Swal.fire({
	 icon: 'success',
	 title: '{{ session()->get('success') }}',
	 showConfirmButton: false,
	 timer: 2000,
	 
   })
	</script>
   <?php } session()->forget('success'); ?>







	</body>

	</html>