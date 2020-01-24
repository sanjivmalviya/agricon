<?php
$connect = mysqli_connect("localhost", "root", "", "agricon");
$query = "SELECT * FROM page ORDER BY page_order ASC";
$result = mysqli_query($connect, $query);
?>
<html>
 <head>
  <title>Sorting Table Row using JQuery Drag Drop with Ajax PHP</title>
  <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
  <script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
   body
   {
    margin:0;
    padding:0;
    background-color:#f1f1f1;
   }
   .box
   {
    width:1270px;
    padding:20px;
    background-color:#fff;
    border:1px solid #ccc;
    border-radius:5px;
    margin-top:25px;
   }
   #page_list li
   {
    padding:16px;
    background-color:#f9f9f9;
    border:1px dotted #ccc;
    cursor:move;
    margin-top:12px;
   }
   #page_list li.ui-state-highlight
   {
    padding:24px;
    background-color:#ffffcc;
    border:1px dotted #ccc;
    cursor:move;
    margin-top:12px;
   }
  </style>
 </head>
 <body>
  <div class="container box">
   <h1 align="center">Sorting Table Row using JQuery Drag Drop with Ajax PHP</h1>
   <br />
   <ul class="list-unstyled" id="page_list">
   <?php 
   while($row = mysqli_fetch_array($result))
   {
    echo '<li id="'.$row["page_id"].'">'.$row["page_title"].'</li>';
   }
   ?>
   </ul>
   <input type="hidden" name="page_order_list" id="page_order_list" />
  </div>
 </body>
</html>

<script>
$(document).ready(function(){
 $( "#page_list" ).sortable({
  placeholder : "ui-state-highlight",
  update  : function(event, ui)
  {
   var page_id_array = new Array();
   $('#page_list li').each(function(){
    page_id_array.push($(this).attr("id"));
   });
   $.ajax({
    url:"update.php",
    method:"POST",
    data:{page_id_array:page_id_array},
    success:function(data)
    {
     alert(data);
    }
   });
  }
 });

});
</script>

