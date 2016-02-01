<!DOCTYPE html>
<html style = "width:100%; height:100%; margin:0; padding:0;">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../assets/ico/favicon.png">

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

	#legend {
        background: #FFF;
        padding: 10px;
        margin: 5px;
        font-size: 12px;
        font-family: Arial, sans-serif;
      }

      .color {
        border: 1px solid;
        height: 12px;
        width: 12px;
        margin-right: 3px;
        float: left;
      }

      .blue {
        background: #06C;
      }

      .purple {
        background: #63C;
      }

	</style>

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../docs-assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB4Eo91YmlaUtqHklBSigAceRyn1TStuOg&libraries=places&sensor=false"
         async defer
            type="text/javascript"></script>
    <script type="text/javascript">
    //<![CDATA[

    var customIcons = {
      female: {
        icon: 'http://labs.google.com/ridefinder/images/mm_20_purple.png'
      },
      male: {
        icon: 'http://labs.google.com/ridefinder/images/mm_20_blue.png'
      }
    };

    function load() {
      var map = new google.maps.Map(document.getElementById("map"), {
        center: new google.maps.LatLng(53.3470797, -6.2517331),
        zoom: 13,
        mapTypeId: 'roadmap'
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
	  
      var infoWindow = new google.maps.InfoWindow;

      // Change this depending on the name of your PHP file
      downloadUrl("loadMarker.php", function(data) {
        var xml = data.responseXML;
        var markers = xml.documentElement.getElementsByTagName("marker");
        for (var i = 0; i < markers.length; i++) {
		  var id = markers[i].getAttribute("id");
          var description = markers[i].getAttribute("description");
          var address = markers[i].getAttribute("address");
          var gender = markers[i].getAttribute("gender");
		  var assign = markers[i].getAttribute("assign");
          var point = new google.maps.LatLng(
              parseFloat(markers[i].getAttribute("lat")),
              parseFloat(markers[i].getAttribute("lng")));
          var html = "<b>Assigned to: </b>" + assign + "<br/><b>Priority Number: </b>"+ id +"<br/><b>Description: </b>" + description + "<br/><b>Location: </b>" + address;
          var icon = customIcons[gender] || {};
          var marker = new google.maps.Marker({
            map: map,
            position: point,
            icon: icon.icon
          });
          bindInfoWindow(marker, map, infoWindow, html);
        }
      });
	// Create the legend and display on the map
        var legend = document.createElement('div');
        legend.id = 'legend';
        var content = [];
        content.push('<h3>Markers</h3>');
        content.push('<p><div class="color blue"></div>Male</p>');
        content.push('<p><div class="color purple"></div>Female</p>');
        legend.innerHTML = content.join('');
        legend.index = 1;
		
        map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(legend);  
    }

    function bindInfoWindow(marker, map, infoWindow, html) {
      google.maps.event.addListener(marker, 'click', function() {
        infoWindow.setContent(html);
        infoWindow.open(map, marker);
      });
    }

    function downloadUrl(url, callback) {
      var request = window.ActiveXObject ?
          new ActiveXObject('Microsoft.XMLHTTP') :
          new XMLHttpRequest;

      request.onreadystatechange = function() {
        if (request.readyState == 4) {
          request.onreadystatechange = doNothing;
          callback(request, request.status);
        }
      };

      request.open('GET', url, true);
      request.send(null);
    }

    function doNothing() {}

    //]]>

  </script>    
    
  </head>

  <body onload="load(); setTimeout(myFunction, 3000);" style = "width:100%; height:100%; margin:0; padding:0;">
    <div class="navmenu navmenu-default navmenu-fixed-left">
	  <a class="navbar-brand" href="welcome.php"><img src = "images/gandideanlogo.png" alt = "Gan Didean" width = "30" height = "30"></a>
      <a class="navmenu-brand" href="#" style = "background: black; color: white;">Gan Dídean - Live Cases</a>
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