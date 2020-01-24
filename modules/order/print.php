<?php require_once('include/connection.php'); ?>
<?php
$invoice_id = $_GET['id'];
$get = "SELECT * FROM invoices WHERE id = '$invoice_id' ";
$get = mysqli_query($connect,$get);
while($rs = mysqli_fetch_assoc($get) ){

    $data[] = $rs;

}

$customer_name = $data[0]['customer_name'];
$customer_mobile = $data[0]['customer_mobile'];
$customer_address = $data[0]['customer_address'];
$customer_pan = $data[0]['customer_pan'];
$customer_gst = $data[0]['customer_gst'];
$customer_state = $data[0]['customer_state'];
$customer_place_of_supply = $data[0]['customer_place_of_supply'];
$vehicle_no = $data[0]['vehicle_no'];
$model = $data[0]['model'];
$km = $data[0]['km'];
$invoice_no = $data[0]['invoice_no'];
$invoice_date = $data[0]['invoice_date'];
$delivery_note = $data[0]['delivery_note'];
$payment_terms = $data[0]['payment_terms'];
$buyer_order_no = $data[0]['buyer_order_no'];
$buyer_order_date = $data[0]['buyer_order_date'];
$dispatch_document_no = $data[0]['dispatch_document_no'];
$delivery_note_date = $data[0]['delivery_note_date'];
$dispatched_through = $data[0]['dispatched_through'];
$destination = $data[0]['destination'];
$terms_of_delivery = $data[0]['terms_of_delivery'];

// Company details
$company = "SELECT * FROM company order by id LIMIT 1 ";
$company = mysqli_query($connect,$company);
while($rs = mysqli_fetch_assoc($company)){
    $data2[] = $rs;
}

$company_name = $data2[0]['name'];
$company_street_address = $data2[0]['street_address'];
$company_city = $data2[0]['city'];
$company_state = $data2[0]['state'];
$company_pincode = $data2[0]['pincode'];
$company_contact = $data2[0]['contact'];
$company_email = $data2[0]['email'];
$company_gst = $data2[0]['gst'];

// Bank details
$bank = "SELECT * FROM bank_detail order by id LIMIT 1 ";
$bank = mysqli_query($connect,$bank);
while($rs = mysqli_fetch_assoc($bank)){
    $data4[] = $rs;
}

$account_holder_name = $data4[0]['account_holder_name'];
$account_number = $data4[0]['account_number'];
$bank_name = $data4[0]['bank_name'];
$ifsc = $data4[0]['ifsc'];

$invoiceDetails = "SELECT * FROM invoice_labour WHERE invoice_id = '$invoice_id' ";
$invoiceDetails = mysqli_query($connect,$invoiceDetails);
while($rs = mysqli_fetch_assoc($invoiceDetails)){
    $data3[] = $rs;
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Print</title>
    </head>
    <style type="text/css">
    /* Both z-index are resolving recursive element containment */
    [background-color] {
    z-index: 0;
    position: relative;
    -webkit-print-color-adjust: exact !important;
    }
    [background-color] canvas {
    display: block;
    position:absolute;
    z-index: -1;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    }
    .btn-inverse {
    background-color: #3b3e47 !important;
    border: 1px solid #3b3e47 !important;
    }
    .btn {
    border-radius: 2px;
    padding: 6px 14px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.16), 0 2px 10px rgba(0, 0, 0, 0.12);
    }
    .waves-effect {
    position: relative;
    cursor: pointer;
    display: inline-block;
    overflow: hidden;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    -webkit-tap-highlight-color: transparent;
    vertical-align: middle;
    z-index: 1;
    will-change: opacity, transform;
    -webkit-transition: all 0.3s ease-out;
    -moz-transition: all 0.3s ease-out;
    -o-transition: all 0.3s ease-out;
    -ms-transition: all 0.3s ease-out;
    transition: all 0.3s ease-out;
    }
    @media print {
    #Header, #Footer { display: none !important; }
    }
    </style>
    <link rel="stylesheet" href="assets/css/print_inquiry.css" media="print">
    <link rel="stylesheet" href="assets/css/print_inquiry.css" media="screen">
    <link href="assets/css/components.css" rel="stylesheet" type="text/css" />
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <!-- jQuery library -->
    <body style="font-family: calibri !important;">
        <section style="padding-top:2%; padding-bottom:2%;">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-xs-12 col-md-offset-2 table-border table-striped">
                        <div id="background" style="z-index: -1;">
                            <p id="bg-text" style="font-size: 100px;opacity: 0.1;cursor: default;z-index: 9999999999;user-select: none;transform: rotate(-40deg);position: absolute;top:450px;left: 60px;"><b>RANJYOT AUTO</b></p>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-xs-12">
                                <p class="font-weight-600 text-center font-28 p-t-10 p-b-10" style="padding-left: 130px;">Bill of Supply <span class="pull-right" style="font-size: 13px;">[Original for Recipient]</span></p>
                            </div>
                        </div>

                         <br>
                         <div class="row" background-color="#ADD8E6" style="background-color: rgb(173, 216, 230);">
                            <div class="col-md-12 col-xs-12">
                                <p class="font-weight-600 text-center p-t-2 p-b-2">SUPPLY DETAIL</p>
                            </div>
                            <canvas id="canvas-0" width="1168" height="62"></canvas>
                        </div>
                        
                        <div class="row">
                            <div class="col-xs-6 col-md-6 p-l-10 p-r-0 b-r-1 b-t-1 p-1 ">
                                <p>Vehicle No. : <strong><?php echo $vehicle_no; ?></strong></p>
                            </div>
                            <div class="col-xs-6 col-md-6 p-l-10 p-r-0 b-t-1 b-r-1 p-1 ">
                                <p>Invoice No. : <strong><?php echo $invoice_no; ?></strong></p>
                            </div>
                        </div>
                        
                        <div class="row ">
                            <div class="col-xs-6 col-md-6 p-l-10 b-r-1 b-t-1 p-1 ">
                                <p>Model : <strong><?php echo $model; ?></strong></p>
                            </div>
                            <div class="col-xs-6 col-md-6 p-l-10 b-r-1 b-t-1 p-1 ">
                                <p>Invoice Date : <strong><?php echo $invoice_date; ?></strong></p>
                            </div>
                          <!--   <div class="col-xs-6 col-md-6 p-l-0 ">
                                &nbsp;
                            </div> -->
                        </div>
                        <div class="row ">
                            <div class="col-xs-6 col-md-6 p-l-10 b-r-1 b-t-1 p-1 ">
                                <p>Km : <strong><?php echo $km; ?></strong></p>
                            </div>
                            <div class="col-xs-6 col-md-6 p-l-10 b-r-1 b-t-1 p-1 ">
                                <p>Order No. : <strong><?php echo $buyer_order_no; ?></strong></p>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-xs-6 col-md-6 p-l-10 b-r-1 b-t-1 p-1 ">
                                <p>Mode of Payment : <strong><?php echo $payment_terms; ?></strong></p>
                            </div>
                            <div class="col-xs-6 col-md-6 p-l-10 b-r-1 b-t-1 p-1 ">
                                <p>Order Date : <strong></strong><?php echo $buyer_order_date; ?></p>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-xs-6 col-md-6 p-l-10 b-r-1 b-t-1 p-1 ">
                                <p>Dispatch Document No. : <strong><?php echo $dispatch_document_no; ?></strong></p>
                            </div>
                            <div class="col-xs-6 col-md-6 p-l-10 b-r-1 b-t-1 p-1 ">
                                <p>Delivery Note : <strong><?php echo $delivery_note; ?></strong></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6 col-md-6 p-l-10 b-t-1 p-r-0 b-r-1 p-1">
                                <p>Dispatched Through : <strong><?php echo $dispatched_through; ?></strong></p>
                            </div>
                            <div class="col-xs-6 col-md-6 p-l-10 b-t-1 p-r-0 b-r-1 p-1">
                                <p>Delivery Note Date : <strong><?php echo $delivery_note_date; ?></strong></p>
                            </div>
                        </div>  
                        <div class="row">
                            <div class="col-xs-6 col-md-6 p-l-10 b-t-1 p-r-0 b-r-1 p-1">
                                <p>Destination : <strong><?php echo $destination; ?></strong></p>
                            </div>
                            <div class="col-xs-6 col-md-6 p-l-10 b-t-1 p-r-0 b-r-1 p-1">
                                <p>Terms of Delivery : <strong><?php echo $terms_of_delivery; ?></strong></p>
                            </div>
                        </div>  

                        
                        <!-- Customer Section -->

                         <br>
                         <div class="row" background-color="#ADD8E6" style="background-color: rgb(173, 216, 230);">
                            <div class="col-md-12 col-xs-12">
                                <p class="font-weight-600 text-center p-t-2 p-b-2">CUSTOMER DETAIL</p>
                            </div>
                            <canvas id="canvas-0" width="1168" height="62"></canvas>
                        </div>
                        
                        <div class="row">
                            <div class="col-xs-6 col-md-6 p-l-10 p-r-0 b-r-1 b-t-1 p-1 ">
                                <p>Mobile : <strong><?php echo $customer_mobile; ?></strong> </p>
                            </div>
                            <div class="col-xs-6 col-md-6 p-l-10 p-r-0 b-r-1 b-t-1 p-1 ">
                                <p>Name : <strong><?php echo $customer_name; ?></strong> </p>
                            </div>                            
                            <div class="col-xs-6 col-md-6 p-l-10 p-r-0 b-t-1 b-r-1 p-1 ">
                                <p>GSTIN/UIN : <strong><?php echo $customer_gst; ?></strong></p>
                            </div>
                        </div>
                        
                        <div class="row ">
                            <div class="col-xs-6 col-md-6 p-l-10 b-r-1 b-t-1 p-1 ">
                                <p>State : <strong><?php echo $customer_state; ?></strong></p>
                            </div>
                            <div class="col-xs-6 col-md-6 p-l-10 b-r-1 b-t-1 p-1 ">
                                <p>PAN : <strong><?php echo $customer_pan; ?></strong></p>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-xs-6 col-md-6 p-l-10 b-r-1 b-t-1 p-1 ">
                                <p>Address : <strong><?php echo $customer_address; ?></strong></p>
                            </div>
                            <div class="col-xs-6 col-md-6 p-l-10 b-r-1 b-t-1 p-1 ">
                                <p>Place of Supply : <strong><?php echo $customer_place_of_supply; ?></strong></p>
                            </div>
                        </div>
                        
                         <!-- Customer Section -->
                         <br>
                         <div class="row" background-color="#ADD8E6" style="background-color: rgb(173, 216, 230);">
                            <div class="col-md-12 col-xs-12">
                                <p class="font-weight-600 text-center p-t-2 p-b-2">COMPANY DETAIL</p>
                            </div>
                            <canvas id="canvas-0" width="1168" height="62"></canvas>
                        </div>
                        
                        <div class="row">
                            <div class="col-xs-6 col-md-6 p-l-10 p-r-0 b-r-1 b-t-1 p-1 ">
                                <p>Name : <strong><?php echo $company_name; ?> </strong></p>
                            </div>
                            <div class="col-xs-6 col-md-6 p-l-10 p-r-0 b-t-1 b-r-1 p-1 ">
                                <p>GSTIN/UIN : <strong><?php echo $company_gst; ?></strong></p>
                            </div>
                        </div>
                        
                        <div class="row ">
                            <div class="col-xs-6 col-md-6 p-l-10 b-r-1 b-t-1 p-1 ">
                                <p>Mobile Number : <strong><?php echo $company_contact; ?></strong></p>
                            </div>
                            <div class="col-xs-6 col-md-6 p-l-10 b-r-1 b-t-1 p-1 ">
                                <p>Email : <strong><?php echo $company_email; ?></strong></p>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-xs-12 col-md-12 p-l-10 b-r-1 b-t-1 p-1 ">
                                <p>Address : <strong><?php echo $company_street_address."<br>".$company_state."<br>".$company_city."-".$company_pincode; ?></strong></p>
                            </div>
                        </div>
                        <div class="row"></div>
                        <br>
                         <div class="row" background-color="#ADD8E6" style="background-color: rgb(173, 216, 230);">
                            <div class="col-md-12 col-xs-12">
                                <p class="font-weight-600 text-center p-t-2 p-b-2">PURCHASE DETAIL</p>
                            </div>
                            <canvas id="canvas-0" width="1168" height="62"></canvas>
                        </div>
                        <div class="row "></div>
                        <div class="row b-t-1" >
                            <div class="col-xs-12 col-md-12 p-l-0 p-r-0">
                                <div class="col-md-1 col-xs-1 b-r-1 p-t-4 p-b-4 p-l-0 p-r-0 text-center" align="center" ><b>Sr No.</b>   </div>
                                <div class="col-md-9 col-xs-9 b-r-1 p-t-4 p-b-4 p-l-0 p-r-0 text-center">
                                    <p><b>Labour</b></p>
                                </div>
                                <div class="col-md-2 col-xs-2 b-r-1 p-t-4 p-b-4 p-l-0 p-r-0 text-center"><b>Qty</b></div>
                               
                            </div>
                        </div>
                        <?php $i=1; $grand_total = 0; foreach ($data3 as $val) { ?>

                        <div class="row b-t-1">

                            <div class="col-xs-12 col-md-12 p-l-0 p-r-0">
                                    <div class="col-md-1 col-xs-1 b-r-1 p-t-3 p-b-3 p-l-0 p-r-0 text-center" align="center" ><?php echo $i++; ?> </div>
                                    <div class="col-md-9 col-xs-9 b-r-1 p-t-3 p-b-3 p-l-0 p-r-0 text-center">
                                        <p><?php echo $val['labour']; ?></p>
                                    </div>
                                    <div class="col-md-2 col-xs-2 b-r-1 p-t-3 p-b-3 p-l-0 p-r-0 text-center"><?php echo $val['charge']; ?></div>
                                </div>                            
                            
                        </div>

                        <?php $grand_total += $val['charge']; }?>

                        <div class="row b-t-1">

                            <div class="col-xs-12 col-md-12 p-l-0 p-r-0">
                                    <div class="col-md-10 col-xs-10 b-r-1 p-t-4 p-b-4 p-l-0 p-r-2 text-right">Grand Total : </div>
                                    <div class="col-md-2 col-xs-2 b-r-1 p-t-4 p-b-4 p-l-0 p-r-0 text-center"><input type="hidden" value="<?php echo $grand_total; ?>" id="grand_total"><b><?php echo $grand_total; ?></b></div>
                                </div>                            
                            
                        </div>

                        <div class="row b-t-1">

                            <div class="col-xs-12 col-md-12 p-l-0 p-r-0">
                                    <div class="col-md-12 col-xs-12 b-r-1 p-t-2 p-b-2 p-l-10 p-r-2 text-left">Amount in words : <b><span id="grand_total_in_words"></span></b> </div>
                                </div>                            
                            
                        </div>
                        
                         <div class="row" background-color="#ADD8E6" style="background-color: rgb(173, 216, 230);">
                            <div class="col-md-12 col-xs-12">
                                <p class="font-weight-600 text-center p-t-2 p-b-2">BANK DETAIL</p>
                            </div>
                            <canvas id="canvas-0" width="1168" height="62"></canvas>
                        </div>
                        
                        <div class="row">
                            <div class="col-xs-6 col-md-6 p-l-10 p-r-0 b-r-1 b-t-1 p-1 ">
                                <p>Bank Name</p>
                            </div>
                            <div class="col-xs-6 col-md-6 p-l-10 p-r-0 b-t-1 b-r-1 p-1 ">
                                <p><strong><?php echo $bank_name; ?></strong></p>
                            </div>
                            <!-- <div class="col-xs-6 col-md-6 p-l-0 ">
                                &nbsp;
                            </div> -->
                        </div>
                        
                        <div class="row ">
                            <div class="col-xs-6 col-md-6 p-l-10 b-r-1 b-t-1 p-1 ">
                                <p>Account Holder</p>
                            </div>
                            <div class="col-xs-6 col-md-6 p-l-10 b-r-1 b-t-1 p-1 ">
                                <p><strong><?php echo $account_holder_name; ?></strong></p>
                            </div>
                          <!--   <div class="col-xs-6 col-md-6 p-l-0 ">
                                &nbsp;
                            </div> -->
                        </div>
                        <div class="row ">
                            <div class="col-xs-6 col-md-6 p-l-10 b-r-1 b-t-1 p-1 ">
                                <p>Account Number</p>
                            </div>
                            <div class="col-xs-6 col-md-6 p-l-10 b-r-1 b-t-1 p-1 ">
                                <p><strong><?php echo $account_number;  ?> </strong></p>
                            </div>
                       <!--      <div class="col-xs-6 col-md-6 p-l-0">
                                &nbsp;
                            </div> -->
                        </div>
                        <div class="row">
                            <div class="col-xs-6 col-md-6 p-l-10 b-t-1 p-r-0 b-r-1 p-1">
                                <p>Bank IFSC</p>
                            </div>
                            <div class="col-xs-6 col-md-6 p-l-10 b-t-1 p-r-0 b-r-1 p-1">
                                <p><strong><?php echo $ifsc; ?></strong></p>
                            </div>
                            <!-- <div class="col-xs-6 col-md-6 p-l-0">
                                &nbsp;
                            </div> -->
                        </div>  
                        <!-- <br> -->
                        <div class="row b-t-1">
                            <div class="col-xs-8 col-md-8 p-l-10 b-r-1 p-1">
                                <p> <strong> Declaration :- </strong>
                                    <ul type="1">
                                        <li>1. Goods once sold will not be taken back or replaced. </li>
                                        <li>2. Cheque Return Charge Rs. 500/-  </li>
                                    </ul>
                                </p>
                            </div>
                            <div class="col-xs-4 col-md-4  ">
                                <p class="text-center" style="padding-top: 60px;"><strong>Authorised signatory</strong> </p>
                                    <!-- <p class="text-center">(This is digitally authorised)</p> -->
                            </div>
                        </div>
                        <div class="row b-t-1">
                            <div class="col-xs-12 col-md-12  ">
                                <p class="text-center" style="font-size: 13px;">SUBJECT TO VADODARA JURISDICTION</p>
                            </div>
                            <div class="col-xs-12 col-md-12  ">
                                <p class="text-center" style="font-size: 12px;">(This is a Computer Generated Invoice)</p>
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
                                    <a href="javascript:window.print()" class="btn btn-default waves-effect waves-light "><i class="fa fa-print"></i> Print Invoice</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </body>
    </html>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script type="text/javascript">

         function convertNumberToWords(amount) {
                var words = new Array();
                words[0] = '';
                words[1] = 'One';
                words[2] = 'Two';
                words[3] = 'Three';
                words[4] = 'Four';
                words[5] = 'Five';
                words[6] = 'Six';
                words[7] = 'Seven';
                words[8] = 'Eight';
                words[9] = 'Nine';
                words[10] = 'Ten';
                words[11] = 'Eleven';
                words[12] = 'Twelve';
                words[13] = 'Thirteen';
                words[14] = 'Fourteen';
                words[15] = 'Fifteen';
                words[16] = 'Sixteen';
                words[17] = 'Seventeen';
                words[18] = 'Eighteen';
                words[19] = 'Nineteen';
                words[20] = 'Twenty';
                words[30] = 'Thirty';
                words[40] = 'Forty';
                words[50] = 'Fifty';
                words[60] = 'Sixty';
                words[70] = 'Seventy';
                words[80] = 'Eighty';
                words[90] = 'Ninety';

                amount = amount.toString();
                var atemp = amount.split(".");
                var number = atemp[0].split(",").join("");
                var n_length = number.length;
                var words_string = "";
                if (n_length <= 9) {
                    var n_array = new Array(0, 0, 0, 0, 0, 0, 0, 0, 0);
                    var received_n_array = new Array();
                    for (var i = 0; i < n_length; i++) {
                        received_n_array[i] = number.substr(i, 1);
                    }
                    for (var i = 9 - n_length, j = 0; i < 9; i++, j++) {
                        n_array[i] = received_n_array[j];
                    }
                    for (var i = 0, j = 1; i < 9; i++, j++) {
                        if (i == 0 || i == 2 || i == 4 || i == 7) {
                            if (n_array[i] == 1) {
                                n_array[j] = 10 + parseInt(n_array[j]);
                                n_array[i] = 0;
                            }
                        }
                    }
                    value = "";
                    for (var i = 0; i < 9; i++) {
                        if (i == 0 || i == 2 || i == 4 || i == 7) {
                            value = n_array[i] * 10;
                        } else {
                            value = n_array[i];
                        }
                        if (value != 0) {
                            words_string += words[value] + " ";
                        }
                        if ((i == 1 && value != 0) || (i == 0 && value != 0 && n_array[i + 1] == 0)) {
                            words_string += "Crores ";
                        }
                        if ((i == 3 && value != 0) || (i == 2 && value != 0 && n_array[i + 1] == 0)) {
                            words_string += "Lakhs ";
                        }
                        if ((i == 5 && value != 0) || (i == 4 && value != 0 && n_array[i + 1] == 0)) {
                            words_string += "Thousand ";
                        }
                        if (i == 6 && value != 0 && (n_array[i + 1] != 0 && n_array[i + 2] != 0)) {
                            words_string += "Hundred and ";
                        } else if (i == 6 && value != 0) {
                            words_string += "Hundred ";
                        }
                    }
                    words_string = words_string.split("  ").join(" ");
                }
                return words_string;
         }

         var grand_total = $('#grand_total').val();
         $('#grand_total_in_words').html(convertNumberToWords(grand_total));
        
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