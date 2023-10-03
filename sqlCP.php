<?php
$servername = "localhost";
$username = "user";
$password = 'G3%DrhG?3tR"gJM5';
$dbname = 'CMPTCAP';

$array=[];
/*
function insertUserSQL($fn, $ln, $DOB, $city, $PN, $username, $password, $USA, $email, $UTID){
	$connection = mysqli_connect('localhost','user','G3%DrhG?3tR"gJM5','CMPTCAP');
  	$insertQuery = "INSERT INTO Users (first_name, last_name, DOB, city, PN, username, password, USA, email, UTID) VALUES ('$fn', '$ln', '$DOB', '$city', '$PN', '$username', '$password', '$USA', '$email', '$UTID')";
 	 $query_run = mysqli_query($connection, $insertQuery);

 	 $connection -> close();
}

function insertReportsSQL($R_Date, $R_Des, $URL, $P_Des, $P_Type, $Verified) {
	  $connection = mysqli_connect('localhost','user','G3%DrhG?3tR"gJM5','CMPTCAP');
 	 $insertQuery = "INSERT INTO Reports (R_Date, R_Des, URL, P_Des, P_Type, Verified) VALUES ('$R_Date', '$R_Des', '$URL', '$P_Des','$P_Type', '$Verified')";
 	 $query_run = mysqli_query($connection, $insertQuery);

 	 $connection -> close();
}


function insertIncidentSQL($DateI, $RID, $ITID) {
	  $connection = mysqli_connect('localhost','user','G3%DrhG?3tR"gJM5','CMPTCAP');
 	 $insertQuery = "INSERT INTO Incidents (DateI, RID, ITID) VALUES ('$DateI', '$RID', '$ITID')";
 	 $query_run = mysqli_query($connection, $insertQuery);

 	 $connection -> close();
}


function insertPeopleSQL($height, $age, $des, $gender) {
  	$connection = mysqli_connect('localhost','user','G3%DrhG?3tR"gJM5','CMPTCAP');
 	 $insertQuery = "INSERT INTO People (Height, Age, Des, Gender) VALUES ('$height', '$age', '$des', '$gender')";
  	$query_run = mysqli_query($connection, $insertQuery);

  	$connection -> close();
}
*/


//Not useed 
function ischeckedSQL($crimeList) {
	$connection = mysqli_connect('localhost','user','G3%DrhG?3tR"gJM5','CMPTCAP');

  	$selectQuery = "SELECT DISTINCT `Neighbourhood Description (Occurrence)` from EPS_Data";
  	$query_run = mysqli_query($connection, $selectQuery);

  	if($query_run->num_rows > 0){
		while($row = $query_run->fetch_assoc()){
			  $array[] = $row["Neighbourhood Description (Occurrence)"];
	  	}
  	} else {
  		echo "0";
 	 }
  	$connection -> close();
  	echo json_encode($array);
}




function selectEPS_DataLocationSQL() {
  	$connection = mysqli_connect('localhost','user','G3%DrhG?3tR"gJM5','CMPTCAP');
  	$selectQuery = "SELECT DISTINCT `Neighbourhood Description (Occurrence)` from EPS_Data";
  	$query_run = mysqli_query($connection, $selectQuery);

  	if($query_run->num_rows > 0){
		while($row = $query_run->fetch_assoc()){
			  $array[] = $row["Neighbourhood Description (Occurrence)"];
	  	}
  	} else {
  		echo "0";
 	 }
  	$connection -> close();
  	echo json_encode($array);
}

/*
function selectEPS_DataLongLatSQL() {
	$connection = mysqli_connect('localhost','user','G3%DrhG?3tR"gJM5','CMPTCAP');
	$selectQuery = "SELECT `latitude`,`longitude`, `Dates` from EPS_Data where `Dates` > '2019-11-01'";
	$query_run = mysqli_query($connection, $selectQuery);

	if($query_run->num_rows > 0){
		while($row = $query_run->fetch_assoc()){
			$array[] = array($row["longitude"],$row["latitude"]);//,$row["Dates"]);
		}
	} else {
		echo "0";
	}
	$connection -> close();
	echo json_encode($array);
}
 */

function selectLocationSQL() {
 	 $connection = mysqli_connect('localhost','user','G3%DrhG?3tR"gJM5','CMPTCAP');
 	 $selectQuery = "SELECT * FROM Location";
 	 $query_run = mysqli_query($connection, $selectQuery);

  	$connection -> close();
}
/*
function selectEPS_DataIncidentSQL() {
  	$connection = mysqli_connect('localhost','user','G3%DrhG?3tR"gJM5','CMPTCAP');
  	$selectQuery = "SELECT DISTINCT `Occurence Violation Type Group` from EPS_Data";
  	$query_run = mysqli_query($connection, $selectQuery);
 	 if($query_run->num_rose > 0){
		while($array = $query_run->fetch_assoc()) {
			$array[(string) $query_run[`Occurence Violation Type Group`]];
		}
  		echo json_encode($array);
  	} else {
  		echo "0";
	}
	  $connection -> close();
}

function selectIncidentSQL() {
  	$connection = mysqli_connect('localhost','user','G3%DrhG?3tR"gJM5','CMPTCAP');
  	$selectQuery = "SELECT * FROM Incidents";
  	$query_run = mysqli_query($connection, $selectQuery);

 	 $connection -> close();
}

function selectAllEPS_DataSQL() {
 	$connection = mysqli_connect('localhost','user','G3%DrhG?3tR"gJM5','CMPTCAP');
  	$selectQuery = "SELECT DISTINCT `Neighbourhood Description (Occurrence)`, `Dates`, `Occurrences`, `Occurrence Violation Type Group`  FROM EPS_Data";
  	$query_run = mysqli_query($connection, $selectQuery);

  	$connection -> close();
}

function selectAllSQL() {
  	$connection = mysqli_connect('localhost','user','G3%DrhG?3tR"gJM5','CMPTCAP');
  	$selectQuery = "SELECT DISTINCT * FROM Incidents";
  	$query_run = mysqli_query($connection, $selectQuery);

  	$connection -> close();
}
 */
//New additions for filters
//filter by location
function selectLocationFilterSQL($NB) {
	$connection = mysqli_connect('localhost','user','G3%DrhG?3tR"gJM5','CMPTCAP');
	$selectQuery = "SELECT `latitude`,`longitude`, `Dates` from EPS_Data where `Dates` > '2019-09-01' and `Neighbourhood Description (Occurrence)` = '$NB'";
	$query_run = mysqli_query($connection, $selectQuery);

	if($query_run->num_rows > 0){
		while($row = $query_run->fetch_assoc()){
			$array[] = array($row["longitude"],$row["latitude"]);
		}
	} else {
		echo "0";									     }
	$connection -> close();
	echo json_encode($array);
}

//filter for dates
function selectDateFilterSQL($date1, $date2) {
	$connection = mysqli_connect('localhost','user','G3%DrhG?3tR"gJM5','CMPTCAP');
	$selectQuery = "SELECT `latitude`,`longitude`, `Dates` from EPS_Data where `Dates` > '$date1' and `Dates` < '$date2'";
	$query_run = mysqli_query($connection, $selectQuery);

	if($query_run->num_rows > 0){
		while($row = $query_run->fetch_assoc()){
			$array[] = array($row["longitude"],$row["latitude"]);
		}
	} else {
		echo "0";									     }
	$connection -> close();
	echo json_encode($array);
}

//filter for crimes
//
//display information on pins

function selectInfoSQL() {
	$connection = mysqli_connect('localhost','user','G3%DrhG?3tR"gJM5','CMPTCAP');
	$selectQuery = "select `latitude`, `longitude`,`Neighbourhood Description (Occurrence)`, `Name`, `Dates`, `Occurrences` from EPS_Data, Incident_Type where `Dates` > '2019-10-01' and EPS_Data.`ITID` = Incident_Type.`ITID`";

	$query_run = mysqli_query($connection, $selectQuery);

	if($query_run->num_rows > 0){
		while($row = $query_run->fetch_assoc()){
			$array[] = array($row["longitude"],$row["latitude"],$row["Neighbourhood Description (Occurrence)"],$row["Name"],$row["Dates"],$row["Occurrences"]);
		}
	} else {
		echo "0";									     }
	$connection -> close();
	echo json_encode($array);
}





switch($_POST['functionname']){

	case 'insertUserSQL':/* fn, ln, DOB, city, PN, username, pasword, usa, email       */
    		$row = insertUserSQL($_POST['arguments'][0], $_POST['arguments'][1], $_POST['arguments'][2], $_POST['arguments'][3], $_POST['arguments'][4], $_POST['arguments'][5], $_POST['arguments'][6], $_POST['arguments'][7], $_POST['arguments'][8], $_POST['arguments'][9]);
    	break;

  	case 'insertReportsSQL':/* $R_Date, $R_Des, $URL, $P_Des, $P_Type, $Verified              */
    		$row = insertReportsSQL($_POST['arguments'][0], $_POST['arguments'][1], $_POST['arguments'][2], $_POST['arguments'][3], $_POST['arguments'][4], $_POST['arguments'][5], $_POST['arguments'][6]);
    	break;

  	case 'insertIncidentSQL':/*$DateI, $RID, $ITID             */
   		 $row = insertIncidentSQL($_POST['arguments'][0], $_POST['arguments'][1], $_POST['arguments'][2]);
    	break;

  	case 'insertPeopleSQL':/* $height, $age, $des, $gender            */
    		$row = insertPeopleSQL($_POST['arguments'][0], $_POST['arguments'][1], $_POST['arguments'][2], $_POST['arguments'][3]);
    	break;

  	case 'selectEPS_DataLocationSQL':
    		selectEPS_DataLocationSQL();
    	break;

  	case 'selectEPS_DataLongLatSQL':
    		selectEPS_DataLongLatSQL();
    	break;

  	case 'selectLocationSQL':
    		selectLocationSQL();
    	break;

  	case 'selectEPS_DataIncidentSQL':
    		selectEPS_DataIncidentSQL();
    	break;

  	case 'selectIncidentSQL':
    		selectIncidentSQL();
    	break;

  	case 'selectAllEPS_DataSQL':
    		selectAllEPS_DataSQL();
   	 break;

  	case 'selectAllSQL':
    		selectAllSQL();
    	break;

	case 'selectLocationFilterSQL':
		selectLocationFilterSQL($_POST['arguments'][0]);
	break;

	case 'selectInfoSQL':
		selectInfoSQL();
	break;

  	default:
    		echo json_encode("Problem");
    	break;

}

?>
