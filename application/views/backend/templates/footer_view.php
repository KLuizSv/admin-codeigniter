    </section>
</section>

</section>
<script type="text/javascript">
    var current_url = "<?php echo current_url(); ?>/"; var base_url = "<?php echo base_url(); ?>"; var backend_url = "<?php echo backend_url(); ?>"; var backend_view = "<?php echo backend_view(); ?>"; var base_view = "<?php echo base_view(); ?>"; var xnToken = "<?php echo MY_Controller::mostrar_session('token'); ?>"; var xnUserId = "<?php echo MY_Controller::mostrar_session('id'); ?>"; var xnUserName = "<?php echo MY_Controller::mostrar_session('nombres') . " " . MY_Controller::mostrar_session('apellidos'); ?>"; var xnChannel = "<?php echo $this->encrypt->sha1('iep'); ?>";
</script>
<script src="<?php echo backend_view(); ?>js/jquery-1.7.2.min.js"></script>
<script src="<?php echo backend_view(); ?>assets/jquery-ui/jquery-ui-1.10.1.custom.min.js"></script>
<script src="<?php echo backend_view(); ?>js/bootstrap.min.js"></script>
<script src="<?php echo backend_view(); ?>js/jquery.validationEngine.js"></script>
<script src="<?php echo backend_view(); ?>js/jquery.validationEngine-es.js"></script>
<script src="<?php echo backend_view(); ?>js/select2.js"></script>
<script src="<?php echo backend_view(); ?>js/select2.min.js"></script>
<script src="<?php echo backend_view(); ?>js/bootstrap-alert.js"></script>
<script src="<?php echo backend_view(); ?>js/alerts.js"></script>
<script src="<?php echo backend_view(); ?>js/accordion-menu/jquery.dcjqaccordion.2.7.js"></script>
<script src="<?php echo backend_view(); ?>js/scrollTo/jquery.scrollTo.min.js"></script>
<script src="<?php echo backend_view(); ?>js/nicescroll/jquery.nicescroll.js" type="text/javascript"></script>
<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="<?php echo backend_view(); ?>js/flot-chart/excanvas.min.js"></script><![endif]-->
<script src="<?php echo backend_view(); ?>assets/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>
<script src="<?php echo backend_view(); ?>assets/skycons/skycons.js"></script>
<script src="<?php echo backend_view(); ?>assets/jquery.scrollTo/jquery.scrollTo.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.5.2/underscore-min.js"></script>
<!--clock init-->
<script src="<?php echo backend_view(); ?>assets/css3clock/js/script.js"></script>
<!--Easy Pie Chart-->
<script src="<?php echo backend_view(); ?>js/custom-select/jquery.customSelect.min.js" ></script>
<!--common script init for all pages-->
<script src="<?php echo backend_view(); ?>assets/bootstrap-switch-master/build/js/bootstrap-switch.js"></script>

<script type="text/javascript" src="<?php echo backend_view(); ?>assets/fuelux/js/spinner.min.js"></script>
<script type="text/javascript" src="<?php echo backend_view(); ?>assets/bootstrap-fileupload/bootstrap-fileupload.js"></script>
<script type="text/javascript" src="<?php echo backend_view(); ?>assets/isotope/jquery.isotope.js"></script>
<script type="text/javascript" src="<?php echo backend_view(); ?>assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="<?php echo backend_view(); ?>assets/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
<script type="text/javascript" src="<?php echo backend_view(); ?>assets/bootstrap-daterangepicker/moment.min.js"></script>
<script type="text/javascript" src="<?php echo backend_view(); ?>assets/bootstrap-daterangepicker/daterangepicker.js"></script>
<script type="text/javascript" src="<?php echo backend_view(); ?>assets/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
<script type="text/javascript" src="<?php echo backend_view(); ?>assets/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
<script type="text/javascript" src="<?php echo backend_view(); ?>assets/jquery-multi-select/js/jquery.multi-select.js"></script>
<script type="text/javascript" src="<?php echo backend_view(); ?>assets/jquery-multi-select/js/jquery.quicksearch.js"></script>
<script type="text/javascript" src="<?php echo backend_view(); ?>assets/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>
<!-- Google Maps -->
<script src="http://maps.google.com/maps/api/js?key=AIzaSyAPfSj3aqT8VjHW1_aXfX4igKHkj4S_DKk&sensor=false&libraries=geometry&v=3.7"></script>
<script type="text/javascript" src="<?php echo backend_view(); ?>assets/google-map/maplace.js"></script>
<!-- Google Maps -->
<script src="<?php echo backend_view(); ?>assets/jquery-tags-input/jquery.tagsinput.js"></script>
<script type="text/javascript" src="<?php echo backend_view(); ?>assets/gritter/js/jquery.gritter.js"></script>

<script type="text/javascript" language="javascript" src="<?php echo backend_view(); ?>assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="<?php echo backend_view(); ?>assets/data-tables/DT_bootstrap.js"></script>
<script src="<?php echo backend_view(); ?>assets/iCheck-master/jquery.icheck.js"></script>
<script src="<?php echo backend_view(); ?>js/jquery.autogrow-textarea.js"></script>
<script src="<?php echo backend_view(); ?>assets/nestable/jquery.nestable.js" type="text/javascript"></script>
<script src="<?php echo backend_view(); ?>js/jquery.blockUI.js"></script>
<script src="<?php echo backend_view(); ?>js/dropzone.js"></script>
<script src="<?php echo backend_view(); ?>js/scripts.js"></script>
<!-- REALTIME -->
<!-- script src="<?php echo backend_view(); ?>js/pubnub.min.js"></script -->

<!-- include summernote css/js -->
<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css" rel="stylesheet">
<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js"></script>
<script src="<?php echo backend_view(); ?>js/summernote-es-ES.js"></script>
<!-- SUMMERNOTE -->
<script src="<?php echo backend_view(); ?>js/backend.js"></script>
</body>
</html>