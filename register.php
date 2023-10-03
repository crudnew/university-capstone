<?php
/*
 *Description:This file  is used when a user wants to register in our website, thee user inputs the information 
 *asked and then that iunformation is used to save a new user in our database. If no problem happeens while
 *creating a new account, the user is redirected to the login page, if any probleem happens, the specific error 
 *message will be displayed
 *Parameters: NONE
 *Returns: NONE
 *Source: https://www.tutorialrepublic.com/php-tutorial/php-mysql-login-system.php
 */

// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = $first_name = $last_name = "";
$username_err = $password_err = $confirm_password_err = $first_name_err = $last_name_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT UID FROM Users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }

    // Validate First Name
    if(empty(trim($_POST["first_name"]))){
        $first_name_err = "Please enter your First Name.";
    } else{
        $first_name = trim($_POST["first_name"]);
    }

    //Validate Last Name
    if(empty(trim($_POST["last_name"]))){
        $last_name_err = "Please enter your Last Name.";
    } else{
        $last_name = trim($_POST["last_name"]);
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO Users (username, password, first_name, last_name, UTID) VALUES (?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssi", $param_username, $param_password, $param_first_name, $param_last_name, $UTID);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_first_name = $first_name;
            $param_last_name = $last_name;
            $UTID = 4;
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Something went wrong. Please try again later.";
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
        <title>Sign Up</title>
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
            <a href="login.php">Login</a>
            <a class="active" href="register.php">Sign Up</a>
        </div>
        <!-- END -->
        
        
        <!-- Header for the main page -->
        <div class="header" id="myHeader" style="font-family: sans-serif">
            <h1>Sign Up</h1>
            <p>Please fill this form to create an account.</p>
        </div>
        
        <!-- Start of form -->
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label><br>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <br>
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label><br>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <br>
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label><br>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <br>
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($first_name_err)) ? 'has-error' : ''; ?>">
                <label>First Name</label><br>
                <input type="first_name" name="first_name" class="form-control" value="<?php echo $first_name; ?>">
                <br>
                <span class="help-block"><?php echo $first_name_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($last_name_err)) ? 'has-error' : ''; ?>">
                <label>Last Name</label><br>
                <input type="last_name" name="last_name" class="form-control" value="<?php echo $last_name; ?>">
                <br>
                <span class="help-block"><?php echo $last_name_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            	</div>
            	<p>Already have an account? <a href="login.php">Login here</a>.</p>
        	</form>
        <!-- End -->
        
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
