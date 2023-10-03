<?php
// Initialize the session
session_start();
?>

<!DOCTYPE html>

<html>

<!--

Statistics Page
Charts provided by: Charts.js

-->
    <head>
        <title>Statistics</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        
	<script src = "http://code.jquery.com/jquery-3.5.1.js"></script>
	<script src = "https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


        <style>
            .header {
                width:100%;
                text-align: center;
                margin-bottom: 100px;
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
            .topnav a.active {
              background-color: #FFB012;
              color: white;
            }
            
            /* END */
            
            /* Start of Stats CSS */
            
            .chartContainer{
                text-align: center;
            }
            
	    /* PIE CHART */
            #pieChart{
                margin: 0 auto;
                margin-bottom: 10px;
		border-style: double;
            }
            
            #yearPie{
                margin-bottom: 5px;
            }
            
            #neighbourhoodPie{
                margin-bottom: 5px;
            }

	    #pieFilter{
		margin-bottom: 100px;
	    }
            
            /* BAR CHART */
            #barChart{
                margin: 0 auto;
                margin-bottom: 10px;
		border-style: double;
            }
            
            #neighbourhoodBar1{
                margin-bottom: 5px;
            }
            
            #neighbourhoodBar2{
                margin-bottom: 5px;
            }
            
            #yearBar{
                margin-bottom: 5px;
            }

	    #barFilter{
		    margin-bottom: 100px;
	    }

	    #addNeighBtn , #removeNeighBtn{
		    display:inline-block;
	    }

            /* END */
            
        </style>
    
    </head>
    <body>
        <!-- Start of Top Navigation bar code -->
        <div class="topnav">
        	<a href="index.php">Home</a>
        	<a class="active" href="statsPage.php">Statistics</a>
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
        <div class="header" id="myHeader" style="font-family: sans-serif">
            <h1>Statistics</h1>
        </div>
        
        <!-- Start of charts -->
        <div class="chartContainer" id="chartContainer">
            <canvas id="pieChart" width="500" height="500"></canvas>
            <label for="neighbourhoodPie">Neighbourhood:</label>
                <select name="neighbourhoodPie" id="neighbourhoodPie">
                </select>
	    <br>
	    <label for="yearPie">Year:</label>
	    <select name="yearPie" id="yearPie">
                        <!--<option selected ="selected">ALL</option> -->
                </select>
		<br>
	    <button type="button" id="pieFilter" onclick="pieClicked()">Confirm Filter</button>
            
            
            <canvas id="barChart" width="500" height="500"></canvas>
            
	    <div class="addRemBtnContainer">
	    <button id="addNeighBtn" onclick="addDiv()">Add Neighbourhood</button>
	    <button id="removeNeighBtn" onclick="removeDiv()">Remove Neighbourhood</button>
	    </div>
	    
	    <br>
	    
	    <label for="neighbourhoodBar1">Neighbourhood:</label>
                <select name="neighbourhoodBar1" id="neighbourhoodBar1">
                </select>
	    

	    <!-- Neighbourhood Bar Chart ComboBoxes -->
	    <div id="neigh2Div" style="display: none;">
		<label for="neighbourhoodBar2">Neighbourhood:</label>
                	<select name="neighbourhoodBar2" id="neighbourhoodBar2">
                	</select>
		
	    </div>
             
	    <div id="neigh3Div" style="display: none;">
                <label for="neighbourhoodBar3">Neighbourhood:</label>
                	<select name="neighbourhoodBar3" id="neighbourhoodBar3">
                	</select>
            	
	    </div>
	    
	    <div id="neigh4Div" style="display: none;">
                <label for="neighbourhoodBar4">Neighbourhood:</label>
                	<select name="neighbourhoodBar4" id="neighbourhoodBar4">
                	</select>
            
	    </div>

	    <div id="neigh5Div" style="display: none;">
                <label for="neighbourhoodBar5">Neighbourhood:</label>
                	<select name="neighbourhoodBar5" id="neighbourhoodBar5">
                	</select>	
	    </div>
	    <!-- END -->


            <br>
            <label for="yearBar">Year:</label>
                <select name="yearBar" id="yearBar">
                </select>
		<br>
	    <button type="button" id="barFilter" onclick="barClicked()">Confirm Filter</button>

        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css">
        <script src="statsPage.js"></script>

        
        
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
