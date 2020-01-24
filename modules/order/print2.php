<?php

   session_start();
   require_once('../../functions.php');

?>

<!DOCTYPE html>

<html lang="en">

   <head>

      <meta charset="UTF-8">

      <title>Inquiry Report</title>


   </head>


   <link href="../user/ assets/css/components.css" rel="stylesheet" type="text/css" />

   <!-- Latest compiled and minified CSS -->

   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

   <!-- jQuery library -->

   <body style="font-family: calibri !important;color:#51266d;">

      <section style="padding-top:2%; padding-bottom:2%;">

         <div class="container">

         <div class="row">

            <div class="col-md-8 col-xs-12 col-md-offset-2 table-border table-striped">

               <div id="background" style="z-index: -1;">

                  <p id="bg-text" style="font-size: 120px;opacity: 0.2;cursor: default;z-index: 9999999999;user-select: none;transform: rotate(-40deg);position: absolute;top:420px;left: -30px; color: #ffb900"><b>LISTDEKHO.COM</b></p>

               </div>

               <div class="row">

                  <div class="col-md-12 col-xs-12">

                     <p class="font-weight-600 text-center font-28 p-t-10 p-b-10 ">Print Copy</p>

                  </div>

               </div>

               <div class="row  b-t-1">

                  <br>

                  <div class="col-xs-12 col-md-12 p-l-0 p-r-0 b-r-1 p-1 " background-color="#51266dd6">

                     <p class="text-center" ><strong style="color:#fff;">BUYER DETAIL</strong></p>

                  </div>

               </div>

               <div class="row">

                  <br>

                  <?php

                     $company_id = $cmpid;

                     $company = "SELECT company_name FROM company WHERE company_id = '$company_id'"; 

                     $companyResult = mysqli_query($connect,$company);

                     $companyName = mysqli_fetch_assoc($companyResult);

                     

                     ?>

                  <div class="col-md-5 col-xs-5 ">

                     <div class="row">

                        <div class="col-md-12 col-xs-12 ">

                           <p ><b>From:</b> <?php echo $companyName['company_name'].' '.$firmName ; ?></p>

                        </div>

                     </div>

                     <div class="row">

                        <div class="col-md-12 col-xs-12 ">

                           <p ><b>Company Name :</b> <?php if(isset($companyName['company_name'])){ echo $companyName['company_name'];} ?></p>

                        </div>

                     </div>

                     <?php 

                        $addressQuery = "SELECT * FROM user_address WHERE user_id = '$sendFromUserId'";

                        $addressResult = mysqli_query($connect,$addressQuery);

                        $addressData = mysqli_fetch_assoc($addressResult);

                        ?>

                     <div class="row">

                        <div class="col-md-12 col-xs-12 ">

                           <p> <b>Address: </b> <?php  echo $head_office_address.','.$pincode; ?></p>

                        </div>

                     </div>

                     <div class="row">

                        <div class="col-md-12 col-xs-12 ">

                           <p><b>Mobile:</b> <?php  echo $admin_contact;  ?></p>

                        </div>

                     </div>

                  </div>

                  <br>

                  <div class="col-md-2 col-xs-2 " align="center">

                  </div>

                  <div class="col-md-5 col-xs-5 " align="right">

                     <div class="row">

                        <div class="col-md-12 col-xs-12 ">

                           <p ><b>GST Number: </b><?php echo $user_gst_no; ?></p>

                        </div>

                        <div class="col-md-12 col-xs-12 ">

                           <p ><b>Order Date: </b><?php echo $date; ?></p>

                        </div>

                     </div>

                      

                  </div>

               </div>

               <div class="row p-b-5 p-t-5 b-b-1"></div>

               <div class="row"></div>

               <br>

               <div class="row" background-color="#51266dd6" style="background-color: rgb(173, 216, 230); color:#fff; margin-top: 30px;">

                  <div class="col-md-12 col-xs-12">

                     <p class="font-weight-600 text-center p-t-5 p-b-5">PRODUCT DETAIL</p>

                  </div>

                  <canvas id="canvas-0" width="1168" height="62"></canvas>

               </div>

               <div class="row "></div>

                    <div class="row b-t-1" >

                  <div class="col-xs-12 col-md-12 p-l-0 p-r-0">

                     <div class="col-md-1 col-xs-1 b-r-1 p-t-10 p-b-10 p-l-0 p-r-0 text-center" align="center" >S.No.</div>

                     <div class="col-md-3 col-xs-3 b-r-1 p-t-10 p-b-10 p-l-0 p-r-0 text-center">

                        <p><b>Order By</b></p>

                     </div>

                     <div class="col-md-3 col-xs-3 b-r-1 p-t-10 p-b-10 p-l-0 p-r-0 text-center"><b>Order for</div>

                     <div class="col-md-3 col-xs-3 b-r-1 p-t-10 p-b-10 p-l-0 p-r-0 text-center"><b>Selected Items</div>

                     <div class="col-md-2 col-xs-2 p-t-10 text-center p-b-10 pull-right"><b>Total Amt</b></div>

                  </div>

               </div>

               <div class="row b-t-1">

                  <?php 

                    

                    $grand_total =0;

                    $getdata = "SELECT * FROM $table WHERE $field = '$table_id'";                                  

                    $getdata = mysqli_query($connect,$getdata);

                      

                          if(mysqli_num_rows($getdata) > 0){

                          $i = 0;

                            while($row = mysqli_fetch_assoc($getdata)){

                            $i++;
                            // print_r($row);
                            // exit;
                            if(isset($row['cost_per_product']) && $row['cost_per_product'] != ""){
                              $row['price'] = $row['cost_per_product'];
                            }else{
                              $row['price'] = $row['price'];                              
                            }

                            if($table=='added_product_manufactured'){

                            $state = 0;

                            $getpay =  mysqli_query($connect,"SELECT assigned_by FROM task_assigned WHERE task_assigned_id = '$table_id' ");

                            $getuser = mysqli_fetch_assoc($getpay);

                            $uid = $getuser['assigned_by'];

                            }else{ 

                            $state = 1;

                             $uid = $row['user_id']; 

                            } 

                           

                           $getuname = "SELECT user_name FROM user WHERE id = '$uid' ";

                           $getuname = mysqli_query($connect,$getuname);

                           $getuname = mysqli_fetch_assoc($getuname);

                     

                     

                      ?>

                  <div class="col-xs-12 col-md-12 p-l-0 p-r-0">

                     <div class="col-md-1 col-xs-1 b-r-1 p-t-5 p-b-5 p-l-0 p-r-0 text-center" align="center"><?php echo $i; ?></div>

                     <div class="col-md-3 col-xs-3 b-r-1 p-t-5 p-b-5 p-l-0 p-r-0 text-center">

                        <p><?php echo ucwords($getuname['user_name']); ?></p>

                     </div>

                     

                     <?php if($state == 0){ ?>



                     <div class="col-md-3 col-xs-3 b-r-1 p-t-5 p-b-5 p-l-0 p-r-0 text-center">

                        <p>Product Added</p>

                     </div>



                     <?php } ?> 



                      <?php 

                        if (isset($row['category_id']))

                        {

                        $getheading['heading'] = '  Product';

                        $category_id = $row['category_id'];

                        $subcategory_id = $row['subcategory_id'];

                        $subsubcategory_id = $row['subsubcategory_id'];

                        $select_cat = $select = mysqli_query($connect, "SELECT * FROM category WHERE category_id = '$category_id' ");

                        $get_cat = mysqli_fetch_assoc($select_cat);

                        $category_name = $get_cat['category_name']."->";

                        $select_subcat = $select = mysqli_query($connect, "SELECT * FROM subcategory WHERE subcategory_id = '$subcategory_id' ");

                        $get_subcat = mysqli_fetch_assoc($select_subcat);

                        $subcategory_name = $get_subcat['subcategory_name']."->";

                        $select_subsubcat = $select = mysqli_query($connect, "SELECT * FROM subsubcategory WHERE subsubcategory_id = '$subsubcategory_id' ");

                        $get_subsubcat = mysqli_fetch_assoc($select_subsubcat);

                        $subsubcategory_name = $get_subsubcat['subsubcategory_name'];

                        ?> 

                     <div class="col-md-3 col-xs-3 b-r-1 p-t-5 p-b-5 p-l-0 p-r-0 text-center"> <?php echo $category_name.$subcategory_name.$subsubcategory_name; ?> </div>

                     <?php

                        }else

                        {

                            $getbanner = mysqli_query($connect,"SELECT * FROM $table WHERE $field = '$table_id'");

                          if($table == 'ad_banner_home_left_details'){

                          

                      ?> 

                     <div class="col-md-3 col-xs-3 b-r-1 p-t-5 p-b-5 p-l-0 p-r-0 text-center">   Home Left Banner</div>

                     <?php   

                        $featch_banner = mysqli_fetch_assoc($getbanner);

                         $leftbanner = $featch_banner['banner'];

                     ?> 

                     <div class="col-md-3 col-xs-3 b-r-1 p-t-5 p-b-5 p-l-0 p-r-0 text-center"> <img src="<?php echo $leftbanner; ?>" style="height: 30px; width: 30px;"></div>

                     <?php

                        }

                        if($table == 'ad_banner_home_right_details'){

                          $getheading['heading'] = '  Home Right Banners';

                     ?> 

                     <div class="col-md-3 col-xs-3 b-r-1 p-t-5 p-b-5 p-l-0 p-r-0 text-center">  Home Right Banners </div>

                     <?php   

                        $featch_banner = mysqli_fetch_assoc($getbanner);

                         $rightbanner1 = $featch_banner['banner1'];

                         $rightbanner2 = $featch_banner['banner2'];

                         $rightbanner3 = $featch_banner['banner3'];

                           $image = explode("?v=", $rightbanner1);

                      ?> 

                     <div class="col-md-3 col-xs-3 b-r-1 p-t-5 p-b-5 p-l-0 p-r-0 text-center"><img src="https://img.youtube.com/vi/<?php echo $image[1];?>/hqdefault.jpg "style="height: 30px; width: 30px;">

                        <img src="<?php echo $rightbanner2; ?>"style="height: 30px; width: 30px;">

                        <img src="<?php echo $rightbanner3; ?>"style="height: 30px; width: 30px;">

                     </div>

                     <?php

                        }

                        if($table == 'ad_banner_dashboard_details'){

                          $getheading['heading'] ='  Deshboard Banners';

                      ?> 

                     <div class="col-md-3 col-xs-3 b-r-1 p-t-5 p-b-5 p-l-0 p-r-0 text-center">  Deshboard Banners</div>

                     <?php   

                        $featch_banner = mysqli_fetch_assoc($getbanner);

                         $desh1 = $featch_banner['banner1'];

                         $desh2 = $featch_banner['banner2'];

                         $desh3 = $featch_banner['banner3'];

                         $row['price'] = $featch_banner['price'];

                         $grand_total  += $row['price'];

                      ?> 

                     <div class="col-md-3 col-xs-3 b-r-1 p-t-5 p-b-5 p-l-0 p-r-0 text-center"><img src="<?php echo $desh1; ?> "style="height: 30px; width: 30px;">

                        <img src="<?php echo $desh2; ?>"style="height: 30px; width: 30px;">

                        <img src="<?php echo $desh3; ?>"style="height: 30px; width: 30px;">

                     </div>


                     <?php

                        }

                        if($table == 'brand_promotion'){

                          

                            $getheading['heading'] = '  Promotion';

                     ?> 

                     <div class="col-md-3 col-xs-3 b-r-1 p-t-5 p-b-5 p-l-0 p-r-0 text-center">  Promotion</div>

                     <?php   

                        $setq = '';

                        while($featch_banner = mysqli_fetch_assoc($getbanner)){

                          $row['price'] = $featch_banner['price'];

                          $cmpid=$featch_banner['company_id'];

                          $getbanner = mysqli_query($connect,"SELECT company_name FROM company WHERE company_id = '$cmpid'");

                            $featch_cmp = mysqli_fetch_assoc($getbanner);         

                            echo $state = 'Selected Area:'.$featch_banner['state'];
                            $setq .= $featch_banner['questions']."<br>";

                        }

                      ?> 

                     <div class="col-md-3 col-xs-3 b-r-1 p-t-5 p-b-5 p-l-0 p-r-0 text-center"><?php echo $questions = 'Questions:'.$setq;  ?></div>

                     <?php

                        }



                        // market survey

                      if($table == 'market_survey'){

                    

                      $getheading['heading'] = '  Market Survey';

                     ?> 

                     <div class="col-md-3 col-xs-3 b-r-1 p-t-5 p-b-5 p-l-0 p-r-0 text-center">  Market Survey </div>

                     <?php   

                        $setq = '';

                        while($featch_banner = mysqli_fetch_assoc($getbanner)){

                          $row['price'] = $featch_banner['price'];

                          $cmpid=$featch_banner['company_id'];

                          $getbanner = mysqli_query($connect,"SELECT company_name FROM company WHERE company_id = '$cmpid'");

                            $featch_cmp = mysqli_fetch_assoc($getbanner);         

                            echo $state = 'Selected Area:'.$featch_banner['state'];

                            

                            $setq .= $featch_banner['questions']."<br>";

                        }

                      ?> 

                     <div class="col-md-3 col-xs-3 b-r-1 p-t-5 p-b-5 p-l-0 p-r-0 text-center"><?php echo $questions = 'Questions:'.$setq;  ?></div>

                     <?php

                        }

                        // ad banner proomotional

                        if($table == 'ad_banner_promotional_details'){

                          $getheading['heading'] = '  Promotion Detail';

                     ?> 

                     <div class="col-md-3 col-xs-3 b-r-1 p-t-5 p-b-5 p-l-0 p-r-0 text-center">  Promotion Detail</div>

                     <?php        

                        while($featch_banner = mysqli_fetch_assoc($getbanner)){

                          

                          $cmpid=$featch_banner['company_id'];

                          $getbanner = mysqli_query($connect,"SELECT company_name FROM company WHERE company_id = '$cmpid'");

                          $company_id = mysqli_query($connect,$company_id);

                          $featch_cmp = mysqli_fetch_assoc($company_id);

                            

                     ?> 

                     <div class="col-md-3 col-xs-3 b-r-1 p-t-5 p-b-5 p-l-0 p-r-0 text-center"><?php   echo $promote_company_name = 'Promotion For:'.$featch_cmp['company_name'];  ?></div>

                     <?php

                        }   

                        }

                        }

                                ?>

                     <div class="col-md-2 col-xs-2 p-t-5 text-center p-b-5 pull-right"><strong><?php echo $row['price']; ?></strong></div>

                     <?php $grand_total += $row['price'];  ?>

                  </div>

                  <?php } } ?>

               </div>

               <div class="row">
                <hr>
                 <div class="col-md-12">
                   <strong><div class="pull-right">Grand Total : <?php echo $grand_total; ?></div></strong>
                 </div>
               </div>

              

               <br>

               <div class="row b-t-1" style="margin-top: 230px;">

                  <div class="col-xs-8 col-md-8 p-l-10 b-r-1 p-1">

                     <p> <strong> Terms and Conditions :- </strong> 

                     <ul type="1">

                        <li>1. Your data will be effect after you pay. </li>

                        <li>2. Date is same as fill by admin.</li>

                        <li>3. No refunds are given by your mistacks.</li>

                     </ul>

                     </p>

                  </div>

                  <div class="col-xs-4 col-md-4  " >

                     <p class="text-center" style="bottom: 0;"><strong>Authorised signatory</strong> </p>

                     <p class="text-center">(This is digitally authorised)</p>

                  </div>

               </div>

               <!-- End Of Report Design  -->

            </div>

         </div>

      </section>

      <section class="p-b-30 ">

         <div class="container">

            <div class="row" align="center">

               <div class="col-md-8 col-md-offset-2">

                  <div class="hidden-print">

                     <div class=" p-b-30 ">

                        <a href="javascript:window.print()" class="btn btn-default waves-effect waves-light "><i class="fa fa-print"></i> Print Report</a>

                     </div>

                  </div>

               </div>

            </div>

         </div>

      </section>

   </body>

</html>

<script type="text/javascript">

   var containers = document.querySelectorAll("[background-color]");

   

   for (i = 0; i < containers.length; i++)

   {

       // Element

       var container = containers[i];

       container.insertAdjacentHTML('beforeend', '<canvas id="canvas-' + i + '"></canvas>');

   

       // Color

       var color = container.getAttribute("background-color");

       container.style.backgroundColor = color;

   

       // Inner Canvas

       var canvas = document.getElementById("canvas-" + i);

       canvas.width = container.offsetWidth;

       canvas.height = container.offsetHeight;

       var ctx = canvas.getContext("2d");

       ctx.fillStyle = color;

       ctx.fillRect(0, 0, canvas.width, canvas.height);

   }

   

   

</script>