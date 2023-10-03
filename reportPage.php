<?php
// Initialize the session
session_start();
?>

<!DOCTYPE html>
<!--
This is the file for the report page
-->

<html>
    <head>
        <meta charset="UTF-8">
        <title>Create Report</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">

		<script src = "http://code.jquery.com/jquery-3.5.1.js"></script>
		<script src = "https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		<script src = "reportPage.js"></script>
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCFpLxXBtbw60ezOmanixKBa8hVIGGkmLg&callback=initMap"></script>

    	<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <style>
            .header {
                width:100%;
                text-align: center;
                margin-bottom: 50px;
            }
            
            /* Start of Top Navigation bar CSS */
            
            /* Add a black background color to the top navigation */
            .topnav {
                background-color: #333;
                overflow: hidden;
	    }

	    .mapBox{
                margin: auto;
                width: 100vw;
                height: 65vh;
                padding: 15px;
                border: 2px solid black;

            }

            /* Style the links inside the navigation bar */
            .topnav a {
              float: left;
              color: #f2f2f2;
              text-align: center;
              padding: 14px 16px;
              text-decoration: none;
              font-size: 17px;
            }

            /* Change the color of links on hover */
            .topnav a:hover {
              background-color: #ddd;
              color: black;
            }

            /* Add a color to the active/current link */
            .topnav a.active {
              background-color: #FFB012;
              color: white;
            }

            /*Centers the form to make it look a bit nicer */
            body {
            text-align: center;
            }

            form {
                display: inline-block;
            }

            .help-block {
                display: block;
                margin-top: 5px;
                margin-bottom: 10px;
                color: #FF0000;
            }

            /* END */
            
        </style>
    </head>
    
    <body>

	<!-- Start of Top Navigation bar code -->
        <div class="topnav">
            <a href="index.php">Home</a>
	    	<a href="statsPage.php">Statistics</a>
        <?php if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
            ?>  <a class="active" href="reportPage.php">Report Crime</a>
                <a href="logout.php">Logout</a>
        <?php } else{ ?>
        <a href="login.php">Login</a>
        <a href="register.php">Sign Up</a>
        <?php } ?>
	</div>
	<!-- END -->

        <!-- Header for the main page -->
        <div class="header" id="myHeader" style="font-family: sans-serif";>
            <h1>Report Page</h1>
	</div>
	
	<div>
		<label for="currentLocation">To use current location please click</label>
		<button class="btn default" id="currentLocation" onclick="currentLocationClick()">HERE</button>
			
	</div>

	<div id="map" class="mapBox"></div>

        <!-- Footer -->
        <div class="w3-row w3-section">
            <div class="w3-third w3-center w3-container w3-black w3-large" style="height:250px">
            <h2>Contact Info</h2>
            <p><i class="fa fa-map-marker" style="width:30px"></i> Alberta, Canada</p>
            <p><i class="fa fa-envelope" style="width:30px"> </i> Email: yegcrimemap@gmail.com</p>
        </div>
        <div class="w3-third w3-center w3-large w3-dark-grey w3-text-white" style="height:250px">
            <h2>Contact Us</h2>
            <p>Any recommendations?  </p>
            <p>Need help?</p>
            <p>Email Us!</p>
        </div>
        <div class="w3-third w3-center w3-large w3-grey w3-text-white" style="height:250px">
            <h2>Like Us</h2>
            <i class="w3-xlarge fa fa-facebook-official"></i><br>
            <i class="w3-xlarge fa fa-pinterest-p"></i><br>
            <i class="w3-xlarge fa fa-twitter"></i><br>
            <i class="w3-xlarge fa fa-flickr"></i><br>
            <i class="w3-xlarge fa fa-linkedin"></i>
        </div>
        </div>
        
    </body>
</html>
