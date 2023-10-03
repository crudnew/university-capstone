<?php
// Initialize the session
session_start();
?>

<!DOCTYPE html>
<!--
This is the file for the front page
-->
<!-- 
    Resources:
    Hamburger Menu provided by: https://www.w3schools.com/howto/howto_css_topnav_right.asp
-->

<html>
    <head>
	<meta charset="UTF-8">
        <title>Crime Map</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
	
	<script src = "https://polyfill.io/v3/polyfill.min.js?features=default"></script>
	<script src = "http://code.jquery.com/jquery-3.5.1.js"></script>
	<script src = "https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script src = "homepage.js"></script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCFpLxXBtbw60ezOmanixKBa8hVIGGkmLg&callback=initMap"></script>

	<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<script>

	$( function() {
                $( "#startDate" ).datepicker({
                    onSelect: function(selected) {
                        $("#endDate").datepicker("option","minDate", selected);
                    }
                });
                $( "#endDate" ).datepicker({
                    onSelect: function(selected) {
                        $("#startDate").datepicker("option","maxDate", selected);
 
			}
                });
            });
           
            
            $( function(){
                $( "#location" )
                        .selectmenu()
                        .selectmenu( "menuWidget" )
                            .addClass( "overflow");
                
	    });

 
	    //document.getElementById("filterCrimeBtn").onclick = function(){
			


	//	}
 
          /*   End */
	</script>

	


        <style>
            h1 {
                width:100%;
                text-align: center;
	    }
	    body {
  		height: 100%;
  		margin: 0;
  		padding: 0;
	    }

	    #legend {
	  	font-family: Arial, sans-serif;
      	 	background: #fff;
       		padding: 10px;
         	margin: 10px;
           	border: 3px solid #000;
            }

            #legend h3 {
           	margin-top: 0;
            }

            #legend img {
            	vertical-align: middle;
            }



	    /* Start of Top Navigation bar CSS */
            
            /* Add a black background color to the top navigation */
            .topnav {
                background-color: #333;
                overflow: hidden;
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
            .topnav a.activeHead {
              background-color: #FFB012;
              color: white;
            }
            
            /* END */
            
            /* vw and vh adjust the width and height, accordingly, to browser window size */
	    .mapBox{
                margin: auto;
                width: 100vw;
                height: 65vh;
                padding: 15px;
                border: 2px solid black;
                
            }
            
            .filterBox{
                margin: auto;
                width: 100vw;
                height: 30vh;
                padding: 15px;
                border: 2px solid black;
                background-color: #B0B0B0;
            }

            .typeBox{
                margin: auto;
                overflow-wrap: normal;
                overflow: auto;
                width: 100vw;
                height: 25vh;
                padding: 15px;
                border: 2px solid black;
                background-color: #CFCFCF;
            }	

	    .overflow{
		height: 200px;
	    }
	
	    fieldset{
                border: 0px;
            }
            
            form#crimeChecks fieldset label{
                margin-bottom: 5px;
                float: left;
                width: 30%;
                margin-right: 18px;
            }
            
            form#crimeChecks fieldset label input[type='checkbox'] {
                margin-left: -18px;
	    }
	
            .collapsible {
                background-color: #777;
                color: white;
                cursor: pointer;
                padding: 18px;
                width: 100%;
                border: none;
                text-align: left;
                outline: none;
                font-size: 15px;
            }

            .active, .collapsible:hover {
                background-color: #555;
            }

            .content {
                padding: 0 18px;
                background-color: white;
                max-height: 0;
                overflow: hidden;
                transition: max-height 0.2s ease-out;
            }
            
            .collapsible:after {
                content: '\02795'; /* Unicode character for "plus" sign (+) */
                font-size: 13px;
                color: white;
                float: right;
                margin-left: 5px;
            }

            .active:after {
                content: "\2796"; /* Unicode character for "minus" sign (-) */
            }
            
            
        </style>
    </head>
    
    <body>

	<!-- divider for the legend-->
	<div id="legend"><h3>Legend</h3></div>
	

	<!-- Start of Top Navigation bar code -->
        <div class="topnav">
            <a class="activeHead" href="index.php">Home</a>
	    <a href="statsPage.php">Statistics</a>
        <?php if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        	?>	<a href="reportPage.php">Report Crime</a>  
        		<a href="logout.php">Logout</a>
        <?php } else{ ?>
        <a href="login.php">Login</a>
        <a href="register.php">Sign Up</a>
        <?php } ?>
	</div>
	<!-- END -->


        <!-- Header for the main page -->
        <div class="header" id="myHeader" style="font-family: sans-serif";>
            <h1>Crime Map</h1>
        </div>
        
        <!-- Container with the box for the map and the filters -->
        <div class="container">
            <div id="map" class="mapBox"></div>	
			
		<!--
		<script>
			let map;
			
			function initMap(){
				var location = {lat: 53.544, lng: -113.491};
				map = new google.maps.Map(document.getElementById("map"), {
					zoom: 11, 
					center: location
				});
			}
		</script>
			-->	

	    <button type="button" class="collapsible">Location / Time Filter:</button>
            <div class="content">
                <label for="location">Select a Location:</label>
                <select name="location" id="location">
                    <option selected ="selected">ALL</option>
                </select>
               <br> 
               <p>Start Date: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" id="startDate"></p>

		<p>End Date: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" id="endDate"></p>
		
		<!--
		<button type="button" id="filter" onclick="buttonClicked()">Filter Crimes</button>
		<label>For all filters</label>
		-->
            </div>
            
            <button type="button" class="collapsible">Crime Type Filter</button>
            <div class="content">
                <form id="crimeChecks">
                    <fieldset class="checkboxes">
                        <label> <input type="checkbox" id="assault" name="assault" value="Assault" checked>  Assault</label>

                        <label> <input type="checkbox" id="breakAndEnter" name="breakAndEnter" value="BreakAndEnter" checked> Break and Enter</label>

                        <label> <input type="checkbox" id="homicide" name="homicide" value="Homicide" checked> Homicide</label>

                        <label> <input type="checkbox" id="robbery" name="robbery" value="Robbery" checked>  Robbery</label>

                        <label> <input type="checkbox" id="Stalking/Harassment" name="Stalkin/Harassment" value="Stalking/Harassment" checked> Stalking/Harassment</label>

                        <label> <input type="checkbox" id="theftFromVehicle" name="theftFromVehicle" value="TheftFromVehicle" checked> Theft From Vehicle</label>

                        <label> <input type="checkbox" id="theftOfVehicle" name="theftOfVehicle" value="TheftOfVehicle" checked> Theft of Vehicle</label>
                        
                        <label> <input type="checkbox" id="suspiciousActivity" name="suspiciousActivity" value="SuspiciousActivity" checked> Suspicious Activity</label>
                        
                        <label> <input type="checkbox" id="arson" name="arson" value="Arson" checked> Arson</label>
                        
                        <label> <input type="checkbox" id="fraud" name="fraud" value="Fraud" checked> Fraud</label>
                        
                        <label> <input type="checkbox" id="hateCrime" name="hateCrime" value="HateCrime" checked> Hate Crime</label>

                    </fieldset>
                </form>
	    </div>
	    <button type="button" id="filter" onclick="buttonClicked()">Filter Crimes</button>
    
            <script>
                var coll = document.getElementsByClassName("collapsible");
                var i;

                for (i = 0; i < coll.length; i++) {
                  coll[i].addEventListener("click", function() {
                    this.classList.toggle("active");
                    var content = this.nextElementSibling;
                    if (content.style.maxHeight){
                      content.style.maxHeight = null;
                    } else {
                      content.style.maxHeight = content.scrollHeight + "px";
                    }
                  });
                }
            </script>


	<!-- THIS IS THE OLD FILTER BOX CODE (NON COLLAPSIBLE) -->

<!--	 
	    <div class="filterBox">
                <strong>Location / Time Filter:</strong><br><br>
                
                <label for="location">Select a Location:</label>
                <select name="location" id="location">
                    <option selected ="selected">ALL</option>
                </select>
                
               	<p>Start Date: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" id="startDate"></p> 
		
               	<p>End Date: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" id="endDate"></p>
		
		<button type="button" id="filter" onclick="buttonClicked()">Filter Crimes</button>
		<label>For all filters</label>

            </div>
 
            <div class="typeBox">
                <form id="crimeChecks">
                    <fieldset class="checkboxes">
			<strong>Crime Type Filter:</strong><br><br>
                        <label> <input type="checkbox" id="assault" name="assault" value="Assault" onclick="isChecked()" >  Assault</label>

                        <label> <input type="checkbox" id="breakAndEnter" name="breakAndEnter" value="BreakAndEnter" onclick="isChecked()"> Break and Enter</label>

                        <label> <input type="checkbox" id="homicide" name="homicide" value="Homicide" onclick="isChecked()"> Homicide</label>

                        <label> <input type="checkbox" id="robbery" name="robbery" value="Robbery" onclick="isChecked()">  Robbery</label>

                        <label> <input type="checkbox" id="Stalking/Harassment" name="Stalking/Harassment" value="Stalking/Harassment?" onclick="isChecked()"> Sexual Assault</label>

                        <label> <input type="checkbox" id="theftFromVehicle" name="theftFromVehicle" value="TheftFromVehicle" onclick="isChecked()"> Theft From Vehicle</label>

			<label> <input type="checkbox" id="theftOfVehicle" name="theftOfVehicle" value="TheftOfVehicle" onclick="isChecked()"> Theft of Vehicle</label>

			<label> <input type="checkbox" id="suspiciousActivity" name="suspiciousActivity" value="SuspiciousActivity" onclick="isChecked()"> Suspicious Activity</label>
                        
                        <label> <input type="checkbox" id="arson" name="arson" value="arson"  onclick="isChecked()"> Arson</label>
                        
                        <label> <input type="checkbox" id="fraud" name="fraud" value="fraud"  onclick="isChecked()"> Fraud</label>
                        
			<label> <input type="checkbox" id="hateCrime" name="hateCrime" value="HateCrime"  onclick="isChecked()"> Hate Crime</label>
-->
                        <!--
                        <div  class="filterTB">
                                <label for = "date:"> Enter date:</label>
                                <input type = "date" id = "CrimeDate" name="CrimeDate"><br><br>
                                <button id="filterCrimeBtn" > Filter </button>
                                </div>
                        -->
                    </fieldset>
                </form>
            </div>
        </div>
        
        
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
