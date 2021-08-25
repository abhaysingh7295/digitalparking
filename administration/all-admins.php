<?php include 'header.php'; ?>

    <div class="wrapper">
        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Admins</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="javascript:void(0);"><?php echo $site_settings_row['site_name']; ?></a></li>
                            <li class="breadcrumb-item active">All Admins</li>
                        </ol>
                    </div>
                </div>
                <!-- end row -->
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">
                          <div class="card-body">
                             
                              <a href="add-admin.php" class="btn btn-info waves-effect waves-light">Add New Admin</a>
                             
                          </div>
                            <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                <tr>
                                      <th>Name</th>
                                      <th style="display: none;">ID</th>
                                      <th>Email/Username</th>
                                      <th>Role</th>
                                       
                                      <th>Registration Date</th>
                                      <th class="">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php  $select_query = $con->query("SELECT * FROM `login` ORDER BY Id DESC");
                                while($row=$select_query->fetch_assoc())
                                {  ?>
                                  <tr class="gradeX" id="user-details-<?php echo $row['Id'];?>"> 
                                    <td><?php echo $row['display_name']; ?></td>
                                     <td style="display: none;"><?php echo $row['Id']; ?></td>
                                    <td><?php echo $row['Email']; ?></td>
                                    <td><?php echo $row['Role']; ?></td> 
                                    
                                    <td><?php echo date('d-m-Y h:i A',$row['date_time']); ?></td>
                                    <td class="center" id="user-action-<?php echo $row['Id'];?>"> 
                                      <?php 
                                    if($row['user_status']==1){ ?>
                                      <a class="" title="Deactivate" href="user-status.php?adminaction=status&user_id=<?php echo $row['Id'];?>&status=0&return=all-admins.php"><i class="fas fa-user-alt-slash" style="color: red;"></i> </a>
                                    <?php } else { ?>
                                      <a class="" title="Activate" href="user-status.php?adminaction=status&user_id=<?php echo $row['Id'];?>&status=1&return=all-admins.php"><i class="fas fa-user-check style="color: green;"></i> </a>
                                    <?php } ?> &nbsp;&nbsp;
                                      <a title="Edit" href="add-admin.php?id=<?php echo $row['Id']; ?>" id="<?php echo $row['Id'];?>" ><i class="fas fa-user-edit"></i></a>&nbsp;&nbsp;

                                      <a title="Delete" href="user-status.php?adminaction=delete&user_id=<?php echo $row['Id'];?>&return=all-admins.php" id="<?php echo $row['Id'];?>" onclick="return confirm('Are you sure to delete this Admin?')" ><i class="far fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                                <?php } ?>
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
                <h5 class="modal-title mt-0">Edit Customer</h5>
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