<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Google Map Tracking</title>
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
  </head>
  <body>

    <div id="map"></div>

    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA0siDlz7oiay5U2iLfyPRC7lavRnpcB9c&callback=initMap"></script>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>

    <script type="text/javascript">

      $(function(){
        
        var routine_id = "<?php echo $_GET['routine_id']; ?>";

        $.ajax({

           url : "ajax/get_map_cordinates.php",
           type : 'POST',
           dataType : 'json',
           data : {routine_id : routine_id},
           success : function(cordinates){
              initMap(cordinates);
           }

        });

        function initMap(flightPlanCoordinates) {

          var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 6,
            center: {lat: 22.348185, lng: 73.195621},
            mapTypeId: 'terrain'
          });

          var flightPath = new google.maps.Polyline({
            path: flightPlanCoordinates,
            geodesic: true,
            strokeColor: '#FF0000',
            strokeOpacity: 1.0,
            strokeWeight: 2
          });

          flightPath.setMap(map);
        }

      });
      

    </script>

  </body>
</html>