
<?php

   require_once('../../functions.php');

   $login_id = $_SESSION['agricon_credentials']['user_id'];

  if($_SESSION['agricon_credentials']['user_type'] == 2){

      $employees = getWhere('tbl_employee','added_by',$login_id);

   }else{

      $employees = getAll('tbl_employee');
    
   }
   
   // $employees = "SELECT * FROM tbl_employee sales INNER JOIN tbl_admins admin ON admin.admin_id = sales.added_by ";
   // $employees = getRaw($employees);

   if(isset($_POST['submit'])){

    if(isset($_POST['flag_target_achieved'])){
      $target_category_achieved = $_POST['target_category_achieved'];
    }else{
      $target_category_achieved = "";
    }

    if($_POST['flag_target_type'] == '1'){

        $form_data = array(
          'target_type' => 1,
          'target_year' => $_POST['target_year'],
          'target_month' => $_POST['target_month'],
          'target_category_amount' => $_POST['target_category_amount'],
          'target_category_achieved' => $target_category_achieved,
          'employee_id' => $_POST['employee_id'],
          'added_by' => $login_id
        );

        if(insert('tbl_target',$form_data)){
           $success = "Target Assigned Successfully";
        }else{
          $error = "Failed to assign Target, try again later";
        }


    }else{

      $i=0;
      foreach ($_POST['category_id'] as $rs) {

          $form_data = array(
            'target_type' => 1,
            'target_year' => $_POST['target_year'],
            'target_month' => $_POST['target_month'],
            'target_category_id' => $rs,
            'target_category_amount' => $_POST['category_amount'][$i],
            'employee_id' => $_POST['employee_id'],
            'added_by' => $login_id
          );

          if(insert('tbl_target',$form_data)){
             $success = "Target Assigned Successfully";
          }else{
            $error = "Failed to assign Target, try again later";
          }

          $i++;
          
      }
      
    }

   }

   $target_months = getAll('tbl_target_months');
   $sub_categories = getAll('tbl_sub_category');

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
                           <h4 class="page-title">Assigning Target to Employee</h4>
                           <div class="clearfix"></div>
                        </div>
                     </div>                   
                  </div>
                  <div class="row">   
                     
                     <div class="col-sm-12">
                        <div class="card-box">
                           <div class="row">
                              <form method="post" class="form-horizontal" role="form">
                                 <div class="col-md-12">
                                    <div class="row">
                                       <div class="col-md-4">
                                          <div class="form-group">
                                             <label for="employee_id">Choose Employee<span class="text-danger">*</span></label>
                                             <select name="employee_id" class="form-control select2">
                                                <?php if(isset($employees) && count($employees) > 0){ ?>

                                                  <?php foreach($employees as $rs){ ?>

                                                      <option value="<?php echo $rs['employee_id']; ?>"><?php echo $rs['employee_name']; ?></option>

                                                  <?php } ?>
                                                <?php } ?>
                                             </select>
                                          </div>
                                       </div>
<!--                                        <div class="col-md-4">
                                          <div class="form-group">
                                             <label for="target_type">Choose Target Type<span class="text-danger">*</span></label>
                                             <select name="target_type" id="target_type" class="form-control select2">
                                                <option value="1">Monthly</option>
                                                <option value="2">Annually</option>
                                             </select>
                                          </div>
                                       </div>

 -->                                        <div class="col-md-4">
                                          <div class="form-group">
                                             <label for="target_year">Choose Year<span class="text-danger">*</span></label>
                                             <select name="target_year" class="form-control select2">
                                                <option value="2019">2019</option>
                                                <option value="2020">2020</option>
                                                <option value="2021">2021</option>
                                             </select>
                                          </div>
                                       </div>

                                       <div class="col-md-4">
                                          <div class="form-group">
                                             <label for="target_month">Choose Month<span class="text-danger">*</span></label>
                                             <select name="target_month" class="form-control select2">
                                              <?php if(isset($target_months) && count($target_months) > 0){ ?>

                                                  <?php foreach($target_months as $rs){ ?>

                                                      <option value="<?php echo $rs['month_id']; ?>"><?php echo $rs['month_name']; ?></option>

                                                  <?php } ?>
                                                <?php } ?>
                                             </select>
                                          </div>
                                       </div>            
                                     
                                    </div>

                                    <div class="row">
                                      
                                        <div class="col-md-4">
                                          <div class="form-group">
                                             <input type="radio" name="flag_target_type" class="flag_target_type" id="flag_target_type0"  value="0" checked>
                                             <label for="flag_target_type0">Target By Category</label>
                                             <input type="radio" name="flag_target_type" class="flag_target_type" id="flag_target_type1"  value="1">
                                             <label for="flag_target_type1">Target By Month</label>
                                          </div>
                                       </div>

                                    </div>

                                    <div class="row category_target_block">

                                      <div class="col-md-12">
                                      
                                      <table class="table table-bordered table-condensed">
                                        <thead>
                                          <tr>
                                          <th width="50%">Select Category</th>
                                          <th width="50%">Enter Amount</th>
                                          <th></th>
                                          </tr>
                                        </thead>

                                        <tbody class="addrow_item">
                                          <tr id="0">
                                            <td>
                                              <select name="category_id[]" id="category_id" class="form-control ">
                                                <?php if(isset($sub_categories) && count($sub_categories) > 0){ ?>
                                                    <?php foreach($sub_categories as $rs){ ?>
                                                        <option value="<?php echo $rs['sub_category_id']; ?>"><?php echo $rs['sub_category_name']; ?></option>
                                                    <?php } ?>
                                                  <?php } ?>                                     
                                              </select>
                                            </td>
                                            <td>
                                             <input type="number" name="category_amount[]" parsley-trigger="change" class="form-control category_amount" id="category_amount">
                                            </td>
                                            <td><i class="fa fa-close close" id="0"></i></td>
                                          </tr>
                                        </tbody>
                                      </table>
                                    </div>

                                    </div>

                                    <div class="row month_target_block" style="display: none;">
                                        <div class="col-md-4">
                                          <div class="form-group">
                                             <label for="target_category_amount">Target Amount<span class="text-danger">*</span></label>
                                             <input name="target_category_amount" class="form-control" >
                                          </div>
                                       </div>
                                    </div>

                                    <div class="col-md-12 flag_target_achieved" style="display: none;">
                                      <label for="flag_target_achieved">
                                      <input type="checkbox" name="flag_target_achieved" id="flag_target_achieved"> Enter Previous Achieved Target 
                                      </label>
                                    </div>

                                    <div class="col-md-12 target_achieved_block m-t-10" style="display: none;">                                       
                                        <div class="form-group">
                                           <label for="target_category_achieved">Target Achieved Amount<span class="text-danger">*</span></label>
                                           <input name="target_category_achieved"  class="form-control" >
                                        </div>

                                    </div>
                                    
                                    <div class="col-md-12">

                                            <span class="pull-left">Grand Total : <span id="grand_total"></span></span>
                                            <button type="button" class="btn btn-warning pull-right" name="add_row" id="add_row">+ Add Row</button>

                                          <div class="col-md-12 p-t-30">
                                            <?php if(isset($success)){ ?>
                                               <div class="alert alert-success"><?php echo $success; ?></div>
                                            <?php }else if(isset($warning)){ ?>
                                               <div class="alert alert-warning"><?php echo $warning; ?></div>
                                            <?php }else if(isset($error)){ ?>
                                               <div class="alert alert-danger"><?php echo $error; ?></div>
                                            <?php } ?>
                                         </div> 
                                          
                                    </div>

                                    <div class="col-md-12">
                                      
                                          <button name="submit" type="submit" class="btn btn-primary btn-bordered waves-effect w-md waves-light m-b-5">Assign</button>
                                       
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
        
        $('#target_type').on('change', function(){

            var val = $(this).val();
            if(val == 2){
              $('.month').hide();
            }else{
              $('.month').show();
            }

        });

        $('#flag_target_achieved').on('change', function(){
            
            if($(this).prop('checked')){           
              $('.target_achieved_block').show();
            }else{
              $('.target_achieved_block').hide();
            }

        });

        var i = 1;

        $('#add_row').on('click', function(){

          $('.addrow_item').append('<tr class='+i+'><td><select name="category_id[]" id="category_id" class="form-control"><?php if(isset($sub_categories)&&count($sub_categories)>0){ foreach($sub_categories as $rs){ ?> <option value="<?php echo $rs['sub_category_id']; ?>"><?php echo $rs['sub_category_name'];?></option><?php } }  ?></select></td><td><input type="number" name="category_amount[]" parsley-trigger="change" required="" class="form-control category_amount" id="category_amount"></td><td><i class="fa fa-close close" id='+i+'></i></td></tr>');

          i++;

        });

        $(document).on('click','.close', function(){
          var id = $(this).attr('id');
          $('.'+id).remove();
          
        });

        $(document).on('input','.category_amount', function(){

            var total = 0;
            $('.category_amount').each(function() {
                  total += parseFloat($(this).val());
            });  

            $('#grand_total').html(total);

        });
        
        $(document).on('click','.flag_target_type', function(){
            
            var flag_target_type = $(this).val();

            if(flag_target_type == '0'){

              $('.category_target_block').css('display','block');
              $('.month_target_block').css('display','none');
              $('.flag_target_achieved').css('display','none');
              $('#flag_target_achieved').prop('checked',false);
              $('.target_achieved_block').hide();

            }else if(flag_target_type == '1'){
              
              $('.flag_target_achieved').css('display','block');

              $('.month_target_block').css('display','block');
              $('.category_target_block').css('display','none');
            }

        });


      </script>

   </body>
</html>
