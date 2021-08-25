<?php include 'header.php'; 



$select_qr = $con->query("SELECT * FROM `vendor_qr_codes` Where vendor_id='".$current_user_id."'");

$row_qr=$select_qr->fetch_assoc();

?>

 <div class="wrapper">
        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">My QR Code</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="javascript:void(0);"><?php echo $site_settings_row['site_name']; ?></a></li>
                            <li class="breadcrumb-item active">My QR Code</li>
                        </ol>
                    </div>
                </div>
                <!-- end row -->
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body myqrcode-card-body">
 						  <?php $QR_FILE_DIR = '../qrcodes/'.$current_user_id.'/'.$row_qr['qr_code'].'.png';
                                if(file_exists($QR_FILE_DIR)){ ?>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <img src="<?php echo $QR_FILE_DIR; ?>" width="400" />
                                </div>
                                <div class="col-sm-12">
                                    <a style="margin-left:100px;" class="btn btn-danger" href="<?php echo $QR_FILE_DIR; ?>" download>Download QR Code</a>
                                </div>
                                </div>
                            </div>
                            <?php } else { ?>
                                 <div class="form-group row">
                                    <div class="col-sm-12">
                                       No QR Code Generate by Admin
                                    </div>
                                </div>

                           <?php  } ?>


                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->   

        </div>
        <!-- end container-fluid -->
    </div>


     



<?php include 'footer.php'; ?>