<?php include 'header.php'; ?>

    <div class="wrapper">
        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">All Vendors</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="javascript:void(0);"><?php echo $site_settings_row['site_name']; ?></a></li>
                            <li class="breadcrumb-item active">All Vendors</li>
                        </ol>
                    </div>
                </div>
                <!-- end row -->
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">

                           
                            <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                <tr>
                                 
                                      <th>S.No.</th>
                                      <th style="display: none;">ID</th>
                                      <th>Name</th>
                                      <th>Parking Place</th>
                                      <th>Address</th>

                                      <th>Email/Username</th>
                                      <th>Mobile No</th>
                                      <th>Activation Date</th>
                                      
                                      <th>Status</th>
                                      
                                      <th class="">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php  $select_query = $con->query("SELECT * FROM `pa_users` WHERE user_role = 'vandor' ORDER BY id DESC");
                                $i = 1;
                                while($row=$select_query->fetch_assoc())
                                {  ?>
                                  <tr class="gradeX" id="user-details-<?php echo $row['id'];?>">
                                    <td><?php echo $i; ?></td>
                                    <td style="display: none;"><?php echo $row['id']; ?></td>
                                    <td><?php echo wordwrap($row['first_name'].' '.$row['last_name'],20,"<br>\n"); ?></td>
                                    <?php $parking_address =  $row['address'].' '.$row['city'].' '.$row['state']; ?> 
                                    <td><?php echo wordwrap($row['parking_name'],15,"<br>\n"); ?></td>
                                    <td><?php echo wordwrap($parking_address,20,"<br>\n"); ?></td>


                                    <td title="<?php echo $row['user_pass']; ?>"><?php echo $row['user_email']; ?></td>
                                    <td><?php echo $row['mobile_number']; ?></td>
                                    <td><?php echo date('d-m-Y h:i A', strtotime($row['register_date'])); ?></td>
                                   
                                    <td><?php if($row['user_status']==1){ ?>
                                      <a class="" title="Deactivate" href="user-status.php?action=status&user_id=<?php echo $row['id'];?>&status=0&return=all-vendors.php"><i class="fas fa-user-alt-slash" style="color: red;"></i> </a>
                                    <?php } else { ?>
                                      <a class="" title="Activate" href="user-status.php?action=status&user_id=<?php echo $row['id'];?>&status=1&return=all-vendors.php"><i class="fas fa-user-check" style="color: green;"></i> </a>
                                    <?php } ?> &nbsp;&nbsp;</td>
                                  
                                  <td class="center" id="user-action-<?php echo $row['id'];?>"> 
                                    <a class="" title="View Parking History" href="all-entity.php?vendor_id=<?php echo $row['id'];?>" id="<?php echo $row['id'];?>"><i class="fas fa-car-alt"></i> </a>&nbsp;&nbsp;
                                    <a class="" title="View Vendor Details" href="user-details.php?user_id=<?php echo $row['id'];?>" id="<?php echo $row['id'];?>"><i class="far fa-eye"></i> </a>&nbsp;&nbsp;
                                    <a class="edit-user-ajax" data-toggle="modal" data-target=".bs-example-modal-center" title="Edit" href="javascript:void(0)" id="<?php echo $row['id'];?>" ><i class="fas fa-user-edit"></i></a>&nbsp;&nbsp;
                                    <a class="" title="View Wallet History" href="wallet-history.php?user_id=<?php echo $row['id'];?>" id="<?php echo $row['id'];?>"><i class="mdi mdi-wallet"></i></a>&nbsp;&nbsp;
                                    <!-- <a title="Delete" href="user-status.php?action=delete&user_id=<?php //echo $row['id'];?>&return=all-vendors.php" id="<?php //echo $row['id'];?>" onclick="return confirm('Are you sure to delete this Vendor?')"><i class="far fa-trash-alt"></i></a>&nbsp;&nbsp; -->
                                    <a class="" title="Qr Code" href="../vendor/genrate-qr-code.php?id=<?php echo $row['id'];?>" id="<?php echo $row['id'];?>"><i class="fas fa-qrcode"></i></a>
                                </td>
                                </tr>
                                <?php $i++;
                              } ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div>
        <!-- end container-fluid -->
    </div>
    <!-- end wrapper -->


    <!-- Modal -->
<div class="modal fade bs-example-modal-center" id="myModaluser" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Edit Vendor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="user-edit-frm">
               
              
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php include 'datatablescript.php'; ?>
<script type="text/javascript">
  $(document).ready(function(){
    $(document).on('click','.edit-user-ajax',function(e){
      var getid = $(this).attr("id"); 
      $('#user-edit-frm').html('loading...');
      $.ajax({
        url:'ajax-edit-user.php',
        type:'POST',
        data:{userid:getid},
        success:function(data){
        $('#user-edit-frm').html(data);
        }
      });
      e.preventDefault(); //STOP default action
      e.unbind();
      return true;  
    });

  $(document).on('submit','#edit-user-submit',function(e){ 
    $('#user-edit-frm-loading').html('loading...');
    var postData = $(this).serializeArray();
    $.ajax(
      {
        url : 'ajax-update-user.php',
        type: "POST",
        data : postData,
        success:function(data, textStatus, jqXHR) 
        {  
          alert(data);
          $("#user-edit-frm-loading").html(data);
          setTimeout(function() {
            $(".close").trigger('click');
          }, 2000);
        }
      });
    e.preventDefault(); //STOP default action
    e.unbind();
    return true;
  });



  })
 

</script>
  <!--main content end-->
  <?php include 'footer.php' ?>