<?php
/*
 *Description:This file  is used when a user wants to login, It checks the database and matches the 
 *information the user inputs and the usernames in the database, if true, thee user is logged in 
 *and reedirected to the home screen, if falsee, the user recievees an error message.
 *Parameters: NONE
 *Returns: NONE
 *Source: https://www.tutorialrepublic.com/php-tutorial/php-mysql-login-system.php
 */

// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
  header("location: index.php");
  exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT UID, username, password FROM Users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $UID, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["UID"] = $UID;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirect user to index page
                            header("location: index.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<!--
Register Page
-->
<html>
    <head>
        <title>Login</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
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
            ?>  <a href="reportPage.php">Report Crime</a>  
                <a href="logout.php">Logout</a>
            <?php } else{ ?>
            <a class="active" href="login.php">Login</a>
            <a href="register.php">Sign Up</a>
            <?php } ?>
        </div>
        <!-- END -->

        <!-- Header for the main page -->
        <div class="header" id="myHeader" style="font-family: sans-serif">
            <h1>Login</h1>
            <p>Please fill in your credentials to login.</p>
        </div>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label><br>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <br>
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label><br>
                <input type="password" name="password" class="form-control">
                <br>
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
        </form>
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
