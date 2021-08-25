<?php 
if(!isset($_SESSION['sess_user']))
{
header('location:login.php');
}
include 'config.php';
?>
<div id="lightbox" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width:50%">
   
    <div class="modal-content">
    <div class="modal-header">
	  <button type="button" class="close hidden" data-dismiss="modal" aria-hidden="true" style=" color: #000 !important; position: relative; right: 3px; z-index: 99;">X</button>
	 <h4 class="modal-title">Modal title</h4>
	 </div>
      <div class="modal-body"> <img src="" alt="" style="width: 100%;"  /> </div>
    </div>
  </div>
</div>

  <!--footer start-->
      <footer class="site-footer">
          <div class="text-center">
              2021 &copy; <?php echo $site_settings_row['site_name']; ?>.
             
          </div>
      </footer>
      <!--footer end-->
  </section>
 
    <!-- js placed at the end of the document so the pages load faster -->
    <script src="js/jquery.js"></script>
    <script src="js/jquery-1.8.3.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="js/jquery.sparkline.js" type="text/javascript"></script>
    <script src="assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js"></script>
    <script src="js/owl.carousel.js" ></script>
    <script src="js/jquery.customSelect.min.js" ></script>
    <script src="js/respond.min.js" ></script>
 <script type="text/javascript" src="assets/ckeditor/ckeditor.js"></script>
  <script type="text/javascript" src="assets/bootstrap-fileupload/bootstrap-fileupload.js"></script>
    <script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
  <script type="text/javascript" src="assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
  <script type="text/javascript" src="assets/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
  <!--<script type="text/javascript" src="assets/bootstrap-daterangepicker/moment.min.js"></script>
  <script type="text/javascript" src="assets/bootstrap-daterangepicker/daterangepicker.js"></script>-->
  <script type="text/javascript" src="assets/jquery-multi-select/js/jquery.multi-select.js"></script>
    <script type="text/javascript" language="javascript" src="assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
 <script src="js/advanced-form-components.js"></script>
    <!--common script for all pages-->
    <script src="js/common-scripts.js"></script>

<script src="js/ajax.js"></script>

    <!--script for this page-->
<!--    <script src="js/sparkline-chart.js"></script>
    <script src="js/easy-pie-chart.js"></script>-->
   <!-- <script src="js/count.js"></script>-->
<script type="text/javascript" charset="utf-8">

$(document).ready(function() {

var $lightbox = $('#lightbox');
    $('[data-target="#lightbox"]').on('click', function(event) {
        var $img = $(this).find('img'), 
            src = $img.attr('src'),
			title = $img.attr('title'),
            alt = $img.attr('alt'),
            css = {
               // 'maxWidth': $(window).width() - 100,
				'maxWidth': '100%',
               'maxHeight': $(window).height() - 100
            };
        $lightbox.find('.close').addClass('hidden');
        $lightbox.find('img').attr('src', src);
        $lightbox.find('img').attr('alt', alt);
		$lightbox.find('img').attr('title', title);
		$lightbox.find('.modal-title').html(title);
        $lightbox.find('img').css(css);
    });
    $lightbox.on('shown.bs.modal', function (e) {
        var $img = $lightbox.find('img');
        //$lightbox.find('.modal-dialog').css({'width': '100%'});
        $lightbox.find('.close').removeClass('hidden');
    });


    var oTable = $('#songsexample').dataTable({"iDisplayLength": 100});
//select#languagefilter,select#songtypes,select#filterbycategroy,select#filterbysubcategroy
  $('select#languagefilter,select#songtypes').change( function() {
   
   var get_val1 = $('select#languagefilter').val();
   var get_val2 = $('select#songtypes').val();
   //var get_val3 = $('select#filterbycategroy').find('option:selected').attr("name");
   //var get_val4 = $('select#filterbysubcategroy').find('option:selected').attr("name");
  
var totalval = get_val1+' '+get_val2;
   oTable.fnFilter( totalval );
 
  } );

 $('#example').dataTable({"iDisplayLength": 25});
 
 var eTable = $('#exampleusers').dataTable({ "iDisplayLength": 50, "retrieve" : true,  "stateSave" : true, "aaSorting": [[ 0, "desc" ]]});

  $('select#loginwith,select#useros,select#domainfliter').change( function() { 

var get_val1 = $('select#loginwith').val();
   var get_val2 = $('select#useros').val();
    var get_val3 = $('select#domainfliter').val();

var totalval = get_val1+' '+get_val2+' '+get_val3;
eTable.fnFilter( totalval ); 
} );

} ); 





          $(document).ready(function() {

 


              $('#example22').dataTable( {
                  //"aaSorting": [[ 0, "desc" ]]
columnDefs: [
  { targets: 'no-sort', orderable: true }
]
              } );





  /*$('#start_date_time,#end_date_time,#news_date').datepicker({
        format: 'mm-dd-yyyy',
       }); */
		

     $('#start_date,#end_date').datepicker({
        format: 'yyyy-mm-dd',
 autoclose: true,
       }).on('changeDate', function (ev) {
     $(this).datepicker('hide');
});

	
			    
          } );

      </script>
  <script>

      //owl carousel

      $(document).ready(function() {
          $("#owl-demo").owlCarousel({
              navigation : true,
              slideSpeed : 300,
              paginationSpeed : 400,
              singleItem : true,
			  autoPlay:true

          });
      });

      //custom select box

      $(function(){
          $('select.styled').customSelect();
      });



 


  </script>
 

  </body>
</html>