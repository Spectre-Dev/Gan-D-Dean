<!DOCTYPE html >
<html style = "width:100%; height:100%; margin:0; padding:0;">
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <title>Gan Dídean</title>
	
	<!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/jasny-bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/navmenu-reveal.css" rel="stylesheet">
	
	<style>
	#pac-input 
	{
		background-color: #fff;
		font-family: Roboto;
		font-size: 15px;
		font-weight: 300;
		margin-left: 12px;
		padding: 0 11px 0 13px;
		text-overflow: ellipsis;
		width: 300px;
	}

	#pac-input:focus 
	{
		border-color: #4d90fe;
	}

	.controls 
	{
		margin-top: 10px;
		border: 1px solid transparent;
		border-radius: 2px 0 0 2px;
		box-sizing: border-box;
		-moz-box-sizing: border-box;
		height: 32px;
		outline: none;
		box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
	}

	</style>
	
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB4Eo91YmlaUtqHklBSigAceRyn1TStuOg&libraries=places&sensor=false"
            type="text/javascript"></script>
    <script type="text/javascript">
    var marker;
    var infowindow;

    function initialize() {
      var latlng = new google.maps.LatLng(53.3470797, -6.2517331);
      var options = {
        zoom: 13,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
      }
	  
	  
	  
      var map = new google.maps.Map(document.getElementById("map"), options);
      var html = "<table>" +
                 "<tr><td>Description:</td> <td><input type='text' id='description'/> </td> </tr>" +
                 "<tr><td>Location:</td> <td><input type='text' id='address'/></td> </tr>" +
                 "<tr><td>Gender:</td> <td><select id='gender'>" +
                 "<option value='male' SELECTED>Male</option>" +
                 "<option value='female'>Female</option>" +
                 "</select> </td></tr>" +
				 "<tr><td>Assigned to:</td> <td><select id='assign'>" +
                 "<option value='unassigned' SELECTED>Unassigned</option>" +
				 "<option value='team1'>Team1</option>" +
                 "<option value='team2'>Team2</option>" +
				 "<option value='team3'>Team3</option>" +
                 "</select> </td></tr>" +
                 "<tr><td></td><td><input type='button' value='Save & Close' onclick='saveData()'/></td></tr>";
    infowindow = new google.maps.InfoWindow({
     content: html
    });
	
	
	// Create the search box and link it to the UI element.
  var input = document.getElementById('pac-input');
  var searchBox = new google.maps.places.SearchBox(input);
  map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

  // Bias the SearchBox results towards current map's viewport.
  map.addListener('bounds_changed', function() {
    searchBox.setBounds(map.getBounds());
  });

  var markers = [];
  // [START region_getplaces]
  // Listen for the event fired when the user selects a prediction and retrieve
  // more details for that place.
  searchBox.addListener('places_changed', function() {
    var places = searchBox.getPlaces();

    if (places.length == 0) {
      return;
    }

    // Clear out the old markers.
    markers.forEach(function(marker) {
      marker.setMap(null);
    });
    markers = [];

    // For each place, get the icon, name and location.
    var bounds = new google.maps.LatLngBounds();
    places.forEach(function(place) {
      var icon = {
        url: place.icon,
        size: new google.maps.Size(71, 71),
        origin: new google.maps.Point(0, 0),
        anchor: new google.maps.Point(17, 34),
        scaledSize: new google.maps.Size(25, 25)
      };

      // Create a marker for each place.
     /* markers.push(new google.maps.Marker({
        map: map,
        icon: icon,
        title: place.name,
        position: place.geometry.location
      }))*/;

      if (place.geometry.viewport) {
        // Only geocodes have viewport.
        bounds.union(place.geometry.viewport);
      } else {
        bounds.extend(place.geometry.location);
      }
    });
    map.fitBounds(bounds);
  });

    google.maps.event.addListener(map, "click", function(event) {
        marker = new google.maps.Marker({
          position: event.latLng,
          map: map
        });
        google.maps.event.addListener(marker, "click", function() {
          infowindow.open(map, marker);
        });
    });
    }
	
	
    function saveData() {
      var description = escape(document.getElementById("description").value);
      var address = escape(document.getElementById("address").value);
      var gender = document.getElementById("gender").value;
	  var assign = document.getElementById("assign").value;
      var latlng = marker.getPosition();

      var url = "addMarker.php?description=" + description + "&address=" + address +
                "&gender=" + gender + "&assign=" + assign + "&lat=" + latlng.lat() + "&lng=" + latlng.lng();
      downloadUrl(url, function(data, responseCode) {
        if (responseCode == 200 && data.length >= 1) {
          infowindow.close();
          document.getElementById("message").innerHTML = "Location added.";
        }
      });
    }

    function downloadUrl(url, callback) {
      var request = window.ActiveXObject ?
          new ActiveXObject('Microsoft.XMLHTTP') :
          new XMLHttpRequest;

      request.onreadystatechange = function() {
        if (request.readyState == 4) {
          request.onreadystatechange = doNothing;
          callback(request.responseText, request.status);
        }
      };

      request.open('GET', url, true);
      request.send(null);
    }

    function doNothing() {}
    </script>
  </head>

  <body onload="initialize(); setTimeout(myFunction, 3000);" style = "width:100%; height:100%; margin:0; padding:0;">
    <div class="navmenu navmenu-default navmenu-fixed-left">
	<a class="navbar-brand" href="welcome.php"><img src = "images/gandideanlogo.png" alt = "Gan Didean" width = "30" height = "30"></a>
      <a class="navmenu-brand" href="#" style = "background: black; color: white;">Gan Dídean - Create Case</a>
      <ul class="nav navmenu-nav">
        <li><a href="liveMap.php">Live Cases</a></li>
        <li><a href="createCase.php">Create Cases</a></li>
        <li><a href="deleteCase.php">Delete Cases</a></li>
        <li><a href="welcome.php">Home</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dashboard</a>
          <ul class="dropdown-menu navmenu-nav">
            <li><a href="genderStats.php">Cases by Gender</a></li>
            <li><a href="teamStats.php">Cases by Team</a></li>
          </ul>
        </li>
      </ul>
    </div>

    <div class="canvas">
      <div class="navbar navbar-default navbar-fixed-top" style = "background-color: transparent;">
        <button type="button" class="navbar-toggle" data-toggle="offcanvas" data-recalc="false" data-target=".navmenu" data-canvas=".canvas">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
      </div>
	
	<input id="pac-input" class="controls" type="text" placeholder="Search Box">
	<div id="map" style = "width:100%; height:100vh; margin:0; padding:0; position:relative;"></div>
    <div id="message"></div>
	</div>
	
	<!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jasny-bootstrap.min.js"></script>
	<script type = "text/javascript">
	//$(document).ready(function(){
    //alert('Please use the button at the right hand corner to expand the side menu');
  //});
	function myFunction() {
    alert('Please use the button at the right hand corner to expand the side menu');
}
  </script>
  </body>

</html>