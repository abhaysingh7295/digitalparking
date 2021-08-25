  <!-- Footer -->
    <footer class="footer">
        © <?php echo date('Y').' '. $site_settings_row['site_name']; ?></span>.
    </footer>

    <!-- End Footer -->

    <!-- jQuery  -->
   
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/jquery.slimscroll.js"></script>
    <script src="assets/js/waves.min.js"></script>

  

 <script src="plugins/dropzone/dist/dropzone.js"></script>

    <!-- App js -->
    <script src="assets/js/app.js"></script>
<script type="text/javascript">
    $(document).ready(function () {

       $('#city-dropdown').select2({}).on('select2-selecting', function (e) {
        var $select = $(this);
        var pid = e.choice.element[0].attributes[0].value;
        if (e.val == '') {
            e.preventDefault();
            var childIds = $.grep(e.target.options, function (option) {
            	return $(option).data('pid') == pid;
            });
            childIds = $.map( childIds, function(option) {
  						return option.value;
						});
            $select.select2('val', $select.select2('val').concat(childIds));
            $select.select2('close');
        }
	});
    })
</script>
</body>

</html>