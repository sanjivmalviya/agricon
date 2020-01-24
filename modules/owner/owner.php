
<?php

   require_once('../../functions.php');

   $login_id = $_SESSION['agricon_credentials']['user_id'];
   $states = getAll('tbl_state');

   $owner = getAll('tbl_owner');

   if(isset($owner)){

  		$old_owner_company_name = $owner[0]['owner_company_name'];
		$old_owner_name = $owner[0]['owner_name'];
		$old_owner_address = $owner[0]['owner_address'];
      $old_owner_state_id = $owner[0]['owner_state_id'];
		$old_owner_city_id = $owner[0]['owner_city_id'];
      $old_cities = getAll('tbl_city','state_id',$old_owner_state_id);
      $old_owner_city_id = $owner[0]['owner_city_id'];
		$old_owner_pincode = $owner[0]['owner_pincode'];
		$old_owner_email = $owner[0]['owner_email'];
		$old_owner_mobile = $owner[0]['owner_mobile'];
      $old_owner_company_vat_tin_number = $owner[0]['owner_company_vat_tin_number'];
      $old_owner_company_cst_number = $owner[0]['owner_company_cst_number'];
      $old_owner_company_pan_number = $owner[0]['owner_company_pan_number'];
      $old_owner_bank_name = $owner[0]['owner_bank_name'];
      $old_owner_bank_account_number = $owner[0]['owner_bank_account_number'];
      $old_owner_bank_ifsc = $owner[0]['owner_bank_ifsc'];

   }


   if(isset($_POST['submit'])){

   	if(truncate('tbl_owner') && truncate('tbl_owner_fertilizer_lic') && truncate('tbl_owner_pesticide_lic')){

		   	$form_data = array(	
		   	'owner_company_name' => $_POST['owner_company_name'],
				'owner_name' => $_POST['owner_name'],
				'owner_address' => $_POST['owner_address'],
				'owner_state_id' => $_POST['owner_state_id'],
				'owner_city_id' => $_POST['owner_city_id'],
				'owner_pincode' => $_POST['owner_pincode'],
				'owner_email' => $_POST['owner_email'],
				'owner_mobile' => $_POST['owner_mobile'],
            'owner_company_vat_tin_number' => $_POST['owner_company_vat_tin_number'],
            'owner_company_cst_number' => $_POST['owner_company_cst_number'],
            'owner_company_pan_number' => $_POST['owner_company_pan_number'],
            'owner_bank_name' => $_POST['owner_bank_name'],
            'owner_bank_account_number' => $_POST['owner_bank_account_number'],
            'owner_bank_ifsc' => $_POST['owner_bank_ifsc']
		   	);

		   	if(insert('tbl_owner',$form_data)){
		   		
		   		$last_owner_id = last_id('tbl_owner','owner_id');

		   		// add fertilizer
		   		$i=0;
		   		foreach($_POST['owner_fertilizer_lic_number'] as $rs){

		   			$form_data = array(
		   				'owner_id' => $last_owner_id,
		   				'owner_fertilizer_lic_number' => $rs,
		   				'owner_fertilizer_lic_date' => $_POST['owner_fertilizer_lic_date'][$i]
		   			);

		   			if(insert('tbl_owner_fertilizer_lic',$form_data)){
		   				$insert = 1;
		   			}

		   		}

		   		foreach($_POST['owner_pesticide_lic_number'] as $rs){

		   			$form_data = array(
		   				'owner_id' => $last_owner_id,
		   				'owner_pesticide_lic_number' => $rs,
		   				'owner_pesticide_lic_date' => $_POST['owner_pesticide_lic_date'][$i]
		   			);

		   			if(insert('tbl_owner_pesticide_lic',$form_data)){
		   				$insert = 1;
		   			}

		   		}
		   		
		   		if($insert == 0){
		   			delete('tbl_owner','owner_id',$last_owner_id);
		   			$error = "Faile to Update Details";
		   		}else{
		   			$success = "Details Updated Successfully";
		   		}
		   		
		   	}
   		
   	}else{

   		$error = "Failed to truncate data";

   	}
   	
   	
      
   }


?>

<!DOCTYPE html>
<html>
   <?php require_once('../../include/headerscript.php'); ?>
   <body class="fixed-left">
      <!-- Begin page -->
      <div id="wrapper">
         <!-- Top Bar Start -->
         <?php require_once('../../include/topbar.php'); ?>
         <!-- Top Bar End -->
         <!-- ========== Left Sidebar Start ========== -->
         <?php require_once('../../include/sidebar.php'); ?>
         <!-- Left Sidebar End -->
         <!-- ============================================================== -->
         <!-- Start Page Content here -->
         <!-- ============================================================== -->
         <div class="content-page">
            <!-- Start content -->
            <div class="content">
               <div class="container">
                   <div class="row">
                     <div class="col-md-6">
                        <div class="page-title-box">
                           <h4 class="page-title">About Owner</h4>
                           <div class="clearfix"></div>
                        </div>
                     </div>                   
                  </div>
                  <div class="row">   
                     
                     <div class="col-sm-12">
                        <div class="card-box">
                           <div class="row">
                               <form method="post" class="form-horizontal" enctype="multipart/form-data">
                                 <div class="col-md-12">
                                    <div class="row">

                                    	<div class="col-md-4">
                                          <div class="form-group">
                                             <label for="owner_company_name">Company Name<span class="text-danger">*</span></label>
                                             <input type="text" name="owner_company_name" parsley-trigger="change" required="" placeholder="" class="form-control" id="owner_company_name" value="<?php if(isset($old_owner_company_name)){ echo $old_owner_company_name; } ?>">
                                          </div>
                                       </div>

                                       <div class="col-md-4">
                                          <div class="form-group">
                                             <label for="owner_name">Owner Name<span class="text-danger">*</span></label>
                                             <input type="text" name="owner_name" parsley-trigger="change" required="" placeholder="" class="form-control" id="owner_name" value="<?php if(isset($old_owner_name)){ echo $old_owner_name; } ?>">
                                          </div>
                                       </div>

                                       <div class="col-md-4">
                                          <div class="form-group">
                                             <label for="owner_address">Owner Address<span class="text-danger">*</span></label>
                                             <input type="text" name="owner_address" parsley-trigger="change" required="" placeholder="" class="form-control" id="owner_address" value="<?php if(isset($old_owner_address)){ echo $old_owner_address; } ?>">
                                          </div>
                                       </div>

                                      <div class="col-md-4">
                                          <div class="form-group">
                                             <label for="owner_state_id">State<span class="text-danger">*</span></label>
                                            <select class="form-control select2" name="owner_state_id" id="owner_state_id">
                                            	<option value="">--Choose State--</option>
                                              <?php if(isset($states) && count($states) > 0){ ?>
                                                <?php foreach($states as $rs){ ?>
                                                
                                                  <option <?php if($old_owner_state_id == $rs['state_id']){ echo "selected"; } ?> value="<?php echo $rs['state_id']; ?>"><?php echo $rs['state_name']; ?></option>

                                                <?php } ?>
                                              <?php } ?>
                                             </select>
                                          </div>
                                       </div>

                                       <div class="col-md-4">
                                          <div class="form-group">
                                             <label for="owner_city_id">City<span class="text-danger">*</span></label>
                                            	<select class="form-control select2" name="owner_city_id" id="owner_city_id">
                                             <?php if(isset($old_cities)){ ?>
                                                <?php foreach($old_cities as $rs){ ?>
                                                <option <?php if($old_owner_city_id == $rs['city_id']){ echo "selected"; } ?> value="<?php echo $rs['city_id']; ?>"><?php echo $rs['city_name']; ?></option>
                                                <?php } ?>    
                                             <?php } ?>    
                                             </select>
                                          </div>
                                       </div>

                                       <div class="col-md-4">
                                          <div class="form-group">
                                             <label for="owner_pincode">Pincode<span class="text-danger">*</span></label>
                                             <input type="text" name="owner_pincode" parsley-trigger="change" required="" placeholder="" class="form-control" id="owner_pincode" value="<?php if(isset($old_owner_pincode)){ echo $old_owner_pincode; } ?>">
                                          </div>
                                       </div>

                                       <div class="col-md-4">
                                          <div class="form-group">
                                             <label for="owner_email">Email<span class="text-danger">*</span></label>
                                             <input type="text" name="owner_email" parsley-trigger="change" required="" placeholder="" class="form-control" id="owner_email" value="<?php if(isset($old_owner_email)){ echo $old_owner_email; } ?>">
                                          </div>
                                       </div>

                                       <div class="col-md-4">
                                          <div class="form-group">
                                             <label for="owner_mobile">Mobile Number<span class="text-danger">*</span></label>
                                             <input type="text" name="owner_mobile" parsley-trigger="change" required="" placeholder="" class="form-control" id="owner_mobile" value="<?php if(isset($old_owner_mobile)){ echo $old_owner_mobile; } ?>">
                                          </div>
                                       </div>    

                                       <div class="col-md-4">
                                          <div class="form-group">
                                             <label for="owner_company_vat_tin_number">Company's VAT TIN<span class="text-danger">*</span></label>
                                             <input type="text" name="owner_company_vat_tin_number" parsley-trigger="change" required="" placeholder="" class="form-control" id="owner_company_vat_tin_number" value="<?php if(isset($old_owner_company_vat_tin_number)){ echo $old_owner_company_vat_tin_number; } ?>">
                                          </div>
                                       </div>   

                                       <div class="col-md-4">
                                          <div class="form-group">
                                             <label for="owner_company_cst_number">Company's CST<span class="text-danger">*</span></label>
                                             <input type="text" name="owner_company_cst_number" parsley-trigger="change" required="" placeholder="" class="form-control" id="owner_company_cst_number" value="<?php if(isset($old_owner_company_cst_number)){ echo $old_owner_company_cst_number; } ?>">
                                          </div>
                                       </div>  

                                       <div class="col-md-4">
                                          <div class="form-group">
                                             <label for="owner_company_pan_number">Company's PAN<span class="text-danger">*</span></label>
                                             <input type="text" name="owner_company_pan_number" parsley-trigger="change" required="" placeholder="" class="form-control" id="owner_company_pan_number" value="<?php if(isset($old_owner_company_pan_number)){ echo $old_owner_company_pan_number; } ?>">
                                          </div>
                                       </div>  

                                       <div class="col-md-4">
                                          <div class="form-group">
                                             <label for="owner_bank_name">Bank Name<span class="text-danger">*</span></label>
                                             <input type="text" name="owner_bank_name" parsley-trigger="change" required="" placeholder="" class="form-control" id="owner_bank_name" value="<?php if(isset($old_owner_bank_name)){ echo $old_owner_bank_name; } ?>">
                                          </div>
                                       </div>     

                                       <div class="col-md-4">
                                          <div class="form-group">
                                             <label for="owner_bank_account_number">Bank Account Number<span class="text-danger">*</span></label>
                                             <input type="text" name="owner_bank_account_number" parsley-trigger="change" required="" placeholder="" class="form-control" id="owner_bank_account_number" value="<?php if(isset($old_owner_bank_account_number)){ echo $old_owner_bank_account_number; } ?>">
                                          </div>
                                       </div>     

                                       <div class="col-md-4">
                                          <div class="form-group">
                                             <label for="owner_bank_ifsc">Bank IFSC <span class="text-danger">*</span></label>
                                             <input type="text" name="owner_bank_ifsc" parsley-trigger="change" required="" placeholder="" class="form-control" id="owner_bank_ifsc" value="<?php if(isset($old_owner_bank_ifsc)){ echo $old_owner_bank_ifsc; } ?>">
                                          </div>
                                       </div>                                   

                                    </div>

                                    <div class="row">
                                    	<div class="col-md-4">
                                    		<div class="form-group">
	                                             <label for="owner_fertilizer_lic_number">Fertilizer LIC Number<span class="text-danger">*</span></label>
	                                             <input type="text" name="owner_fertilizer_lic_number[]" parsley-trigger="change" class="form-control" id="owner_fertilizer_lic_number" placeholder="LIC number">
	                                             <div style="margin-top: 10px;">
	                                             	<input type="text" name="owner_fertilizer_lic_date[]" parsley-trigger="change" required="" placeholder="Date" class="form-control" id="owner_fertilizer_lic_date">
	                                             </div>
                                          	</div>

                                          	<div>

                                          		<div class="add-fertilizer-block"></div>
                                          		
	                                          	<div class="col-md-12">
	                                    			<input type="button" class="btn btn-primary btn-block add_fertilizer" value="+ Add Fertilizer Number">
	                                        	</div>
                                          	
                                          	</div>


                                        </div>                        

                                        <div class="col-md-4">
                                    		<div class="form-group">
	                                             <label for="owner_pesticide_lic_number">Pesticide LIC Number<span class="text-danger">*</span></label>
	                                             <input type="text" name="owner_pesticide_lic_number[]" parsley-trigger="change" required="" placeholder="LIC Number" class="form-control" id="owner_pesticide_lic_number">
                                              <div style="margin-top: 10px;">
	                                             <input type="text" name="owner_pesticide_lic_date[]" parsley-trigger="change" required="" placeholder="Date" class="form-control" id="owner_pesticide_lic_date">
	                                         </div>
                                          	</div>

                                          	<div>

                                          		<div class="add-pesticide-block"></div>
                                          		
	                                          	<div class="col-md-12">
	                                    			<input type="button" class="btn btn-primary btn-block add_pesticide" value="+ Add Pesticide Number">
	                                        	</div>
                                          	
                                          	</div>

                                        </div>                                    	
                                    </div>


                                    <div class="row">
                                       <div class="col-md-12 p-t-30">
                                          <?php if(isset($success)){ ?>
                                             <div class="alert alert-success"><?php echo $success; ?></div>
                                          <?php }else if(isset($warning)){ ?>
                                             <div class="alert alert-warning"><?php echo $warning; ?></div>
                                          <?php }else if(isset($error)){ ?>
                                             <div class="alert alert-danger"><?php echo $error; ?></div>
                                          <?php } ?>
                                       </div>      

                                       <div class="col-md-12" align="right">
                                          <button type="submit" name="submit" id="submit" class="btn btn-primary btn-bordered waves-effect w-md waves-light m-b-5">Submit</button>
                                       </div>
                                    </div>
                                 </div>
                              </form>
                           </div>
                        </div>
                     </div>
                
                  </div>
                 
               </div>
               <!-- container -->
            </div>
            <!-- content -->
         </div>
         <!-- ============================================================== -->
         <!-- End of the page -->
         <!-- ============================================================== -->
      </div>
      <!-- END wrapper -->
      <!-- START Footerscript -->
      <?php require_once('../../include/footerscript.php'); ?>

      <script>
         
         var i = 0,j = 0;
         
         $('.add_fertilizer').on('click', function(){
         	$('.add-fertilizer-block').append('<div class="form-group block_'+i+'"><label for="owner_fertilizer_lic_number">Fertilizer LIC Number <span  style="margin-left:10px;cursor:pointer;"> [<i class="fa fa-close close_fertilizer_block" data-block='+i+' ></i>]</span> <span class="text-danger">*</span></label><input type="text" name="owner_fertilizer_lic_number[]" parsley-trigger="change" required="" placeholder="LIC Number" class="form-control" id="owner_fertilizer_lic_number"><div style="margin-top: 10px;"><input type="text" name="owner_fertilizer_lic_date[]" parsley-trigger="change" required="" placeholder="Date" class="form-control" id="owner_fertilizer_lic_date"></div></div>');
         	i++;

         });

         $('.add_pesticide').on('click', function(){

         	$('.add-pesticide-block').append('<div class="form-group block_'+j+'"><label for="owner_pesticide_lic_number">Pesticide LIC Number<span class="text-danger">*</span><span style="margin-left:10px;cursor:pointer;">[<i class="fa fa-close close_pesticide_block" data-block='+j+'>]</span></i></label><input type="text" name="owner_pesticide_lic_number[]" parsley-trigger="change" required="" placeholder="LIC Number" class="form-control" id="owner_pesticide_lic_number"><div style="margin-top: 10px;"><input type="text" name="owner_pesticide_lic_date[]" parsley-trigger="change" required="" placeholder="Date" class="form-control" id="owner_pesticide_lic_date"></div></div>');
         	j++;
         });

         $('#owner_state_id').on('change', function(){

         		var state_id = $(this).val();

         		$.ajax({

         			url : 'ajax/get_city.php',
         			type : 'POST',
         			dataType : 'json',
         			data : { state_id : state_id },
         			success : function(html){

         				$('#owner_city_id').html(html);

         			}

         		});

         });

         $(document).on('click','.close_fertilizer_block', function(){

         	var block_id = $(this).attr('data-block');
         	$('.block_'+block_id).remove();

         });

         $(document).on('click','.close_pesticide_block', function(){

         	var block_id = $(this).attr('data-block');
         	$('.block_'+block_id).remove();

         });

      </script>

   </body>
</html>