<?php
session_start();

//
// Grabs incident types and inputs them into the combobox
//
// Parameters: None
//
// Return: selects incident name from crimes
//

function selectIncidentSQL() {
  	$connection = mysqli_connect('localhost','user','G3%DrhG?3tR"gJM5','CMPTCAP');
  	$selectQuery = "SELECT `Name` from Incident_Type order by `Name`";
  	$query_run = mysqli_query($connection, $selectQuery);

  	if($query_run->num_rows > 0){
		while($row = $query_run->fetch_assoc()){
			  $array[] = $row["Name"];
		}
		$connection -> close();
		echo json_encode($array);
	} else {
		$connection -> close();
		echo json_encode(0);
 	 }
}

//
// Grabs Neighbourhood name and inputs it into the combobox
//
// Parameters: takes lat and long
//
// Return: selects incident name from crimes
//


function getNBSQL($lat, $long){
  	$connection = mysqli_connect('localhost','user','G3%DrhG?3tR"gJM5','CMPTCAP');
  	$insertQuery = "select `Neighbourhood Description (Occurrence)` as NB from NH_Locations where `lat_max` >  '$lat' and  `lat_min` < '$lat' and lon_max > '$long' and lon min < '$long'";
  	$query_run = mysqli_query($connection, $selectQuery);

  	if($query_run->num_rows > 0){
		while($row = $query_run->fetch_assoc()){
			  $array[] = $row["NB"];
		}
		$connection -> close();
		echo json_encode($array);
	} else {
		$connection -> close();
		echo json_encode(0);
 	 }
}


//
// Insert user report into the tables
//
// Parameters: None
//
// Return: selects incident name from crimes 
//

function insertReportSQL($rDate, $incidentDesc, $iDate, $img, $personDesc, $verified, $userID, $iName, $lat, $lng) {
  	$connection = mysqli_connect('localhost','user','G3%DrhG?3tR"gJM5','CMPTCAP');	

	$iType = 0;

	//getting the ITID of the incident
	$selectIncQuery = "SELECT DISTINCT `ITID` from Incident_Type where `Name` = '$iName'";
  	$query_run1 = mysqli_query($connection, $selectIncQuery);

	while($row = $query_run1->fetch_assoc()){
		$iType = $row["ITID"];
	}

	//Neighbourhood names 
  	$selectNBQuery = "select `NH_Name` from NH_locations where `lat_max` >  '$lat' and  `lat_min` < '$lat' and lon_max > '$lng' and lon_min < '$lng'";
  	$query_run2 = mysqli_query($connection, $selectNBQuery);
  	if($query_run2->num_rows > 0){
		while($row = $query_run2->fetch_assoc()){
			  $NB = $row["NH_Name"];
		}
	} else {
		$NB = "Unknown Neighbourhood";
 	 }


	//Insert the data into the reports
	$insertReportQuery = "INSERT INTO Reports (`Report_Date`, `Report_Desc`, `Incident_Date`, `Photo_URL`, `Involved_Person_Desciption`, `Verified`, `UID`, `ITID`, `Latitude`, `Longitude`) VALUES ('$rDate', '$incidentDesc', '$iDate', '$img', '$personDesc', '$verified', '$userID', '$iType', '$lat', '$lng')";

  	$query_run3 = mysqli_query($connection, $insertReportQuery);

  	if($query_run3){
		echo json_encode("it worked 1");
	}
	else {
		echo json_encode("0");
	}

	//getting max RID 
  	$selectRIDQuery = "SELECT MAX(RID) as `RID` FROM Reports";
  	$query_run4 = mysqli_query($connection, $selectRIDQuery);

	while($row = $query_run4->fetch_assoc()){
		$RID = $row["RID"];
	}

	//insert location along with report id
	$insertLocationQuery = "INSERT INTO Incident_Location (`RID`, `Latitude`, `Longitude`, `NH_Name`) VALUES ('$RID', '$lat', '$lng', '$NB')";

  	$query_run5 = mysqli_query($connection, $insertLocationQuery);

  	if($query_run5){
		echo json_encode("it worked 2");
	}
	else {
		//echo json_encode("0");
		echo json_encode("$RID $lat $lng $NB");

	}

	$connection -> close();
}


//Switch statement for the functions 

switch($_POST['functionname']){

  	case 'selectIncidentSQL':
    		selectIncidentSQL();
	break;

	case 'getNBSQL':
		getNBSQL($_POST['arguments'][0], $_POST['arguments'][1]);
	break;

	case 'insertReportSQL':
		insertReportSQL($_POST['arguments'][0], $_POST['arguments'][1], $_POST['arguments'][2], $_POST['arguments'][3], $_POST['arguments'][4], $_POST['arguments'][5], $_POST['arguments'][6], $_POST['arguments'][7], $_POST['arguments'][8], $_POST['arguments'][9]);
	break;
  
	default:
    		echo json_encode("Problem");
    	break;

}

?>

