<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <style type="text/css">

		body { color: black; 
		background: white;
		font-size: small;
		font-family: Arial, Helvetica, sans-serif }

		/* h1 for page title */
		h1 { 
		font-weight: bold; 
		color: green; 
		font-size: large;
		font-variant: small-caps; 
		border: thin solid purple;
		border-radius: 10px;
		background: aqua; 
		display: inline-block;
		padding: 10px }

		#map_canvas { border: 3px solid gray}
		
		.map_popup h2 { 
			font-weight: bold;
			font-size: small
		}

	  </style>
	<?php include("display.php") ?>
	<?php include("map.js") ?>
        <script>
          function submitForm() {
            document.getElementById("myForm").submit();
          }
        </script>
  </head>
  <body onload="initialize()">
	<h1>Google Maps example</h1>
  <a href="admin.php">Admin</a>
  <form id="myForm">
    <input type="text" name="ins" id="ins">
    <select name="searchBy" id="searchBy">
      <option value="inscription">inscription</option>
      <option value="postcode">postcode (0.1 degree proximity)</option>
      <option value="title">title</option>
      <option value="address">address</option>
    </select>
    <input type="button" onclick="submitForm()" value="Search">
  </form>
  <div id="map_canvas" style="width:800px; height:500px"></div>
  </body>
</html>
