<?php


// This puts neighbourhood info on the combobox
// 
// Returns: Returns data for locations
//
// Parametrs: None
//


function selectNeighbourhoodSQL() {
  	$connection = mysqli_connect('localhost','user','G3%DrhG?3tR"gJM5','CMPTCAP');
  	$selectQuery = "SELECT DISTINCT `Neighbourhood Description (Occurrence)` from EPS_Data order by `Neighbourhood Description (Occurrence)`";
  	$query_run = mysqli_query($connection, $selectQuery);

  	if($query_run->num_rows > 0){
		while($row = $query_run->fetch_assoc()){
			  $array[] = $row["Neighbourhood Description (Occurrence)"];
		}
		$connection -> close();
		echo json_encode($array);
	} else {
		$connection -> close();
		echo json_encode(0);
 	 }
}


// This is for all the years combobox
// 
// Returns: Years
//
// Parametrs: None
//


function selectYearPieSQL() {
  	$connection = mysqli_connect('localhost','user','G3%DrhG?3tR"gJM5','CMPTCAP');
  	$selectQuery = "SELECT distinct SUBSTRING(`Dates`, 1, 4) as year1 from EPS_Data order by year1";
  	$query_run = mysqli_query($connection, $selectQuery);

  	if($query_run->num_rows > 0){
		while($row = $query_run->fetch_assoc()){
			  $array[] = $row["year1"];
		}	
	}

  	$selectQuery = "SELECT distinct SUBSTRING(`Report_Date`, 1, 4) as year2 from Reports order by year2";
  	$query_run = mysqli_query($connection, $selectQuery);

  	if($query_run->num_rows > 0){
		while($row = $query_run->fetch_assoc()){
			  array_push($array, $row["year2"]);
		}
		$connection -> close();
		echo json_encode($array);
	} else {
		$connection -> close();
		echo json_encode(0);
 	 }
}


// This is for the EPS table and displays information on the pie chart
// 
// Returns: Returns report table data to put into stats page
//
// Parametrs: Neighbourhood and dates list:

function pieSQL($NB, $Date) {

	$selectQuery = "select `Name` from EPS_Data, Incident_Type where `Dates` > '$Date-01-00' and `Dates` < '$Date-12-32' and `Neighbourhood Description (Occurrence)` = '$NB' and EPS_Data.`ITID` = Incident_Type.`ITID`";

	$connection = mysqli_connect('localhost','user','G3%DrhG?3tR"gJM5','CMPTCAP');
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


// This is for the Reports table that puts data in the pie chart
// 
// Returns: Returns report table data to put into stats page
//
// Parametrs: Neighbourhood and dates list:
//

function pieReportSQL($NB, $Date) {

	$selectQuery = "select `Name` from Reports, Incident_Type, Incident_Location where `Report_Date` > '$Date-01-00' and `Report_Date` < '$Date-12-32' and Reports.`RID` = Incident_Location.`RID` and `NH_Name` = '$NB' and Reports.`ITID` = Incident_Type.`ITID`";

	$connection = mysqli_connect('localhost','user','G3%DrhG?3tR"gJM5','CMPTCAP');
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


// This is for the EPS  table puts data on the bar chart
// 
// Returns: Returns report table data to put into stats page
//
// Parametrs: Neighbourhood and dates list:
//

function barSQL($NB, $Date) {

	$NBList = join("','", $NB);

	$selectQuery = "select `Name`, `Dates` from EPS_Data, Incident_Type where `Dates` > '$Date-01-00' and `Dates` < '$Date-12-32' and `Neighbourhood Description (Occurrence)` in ('$NBList') and EPS_Data.`ITID` = Incident_Type.`ITID`";

	$connection = mysqli_connect('localhost','user','G3%DrhG?3tR"gJM5','CMPTCAP');
	$query_run = mysqli_query($connection, $selectQuery);

	if($query_run->num_rows > 0){
		while($row = $query_run->fetch_assoc()){
			$array[] = array($row["Name"], $row["Dates"]);
		}
		$connection -> close();
		echo json_encode($array);
	} else {
		$connection -> close();
		echo json_encode(0);
	}
}

// This is for the Reports table and dispalys information on the bar chart
// 
// Returns: Returns report table data to put into stats page
//
// Parametrs: Neighbourhood and dates list:
//
function barReportSQL($NB, $Date) {

	$NBList = join("','", $NB);
	
	$selectQuery = "select `Name`, `Report_Date` from Reports, Incident_Location, Incident_Type where `Report_Date` > '$Date-01-00' and `Report_Date` < '$Date-12-32' and `NH_Name` in ('$NBList') and Reports.`RID` = Incident_Location.`RID` and Reports.`ITID` = Incident_Type.`ITID`";

	$connection = mysqli_connect('localhost','user','G3%DrhG?3tR"gJM5','CMPTCAP');
	$query_run = mysqli_query($connection, $selectQuery);

	if($query_run->num_rows > 0){
		while($row = $query_run->fetch_assoc()){
			$array[] = array($row["Name"], $row["Report_Date"]);
		}
		$connection -> close();
		echo json_encode($array);
	} else {
		$connection -> close();
		echo json_encode(0);
	}
}



//Switch statement to check functions what are called


switch($_POST['functionname']){

  	case 'selectNeighbourhoodSQL':
    		selectNeighbourhoodSQL();
    	break;

	case 'pieSQL':
		pieSQL($_POST['arguments'][0], $_POST['arguments'][1]);
	break;
	
	case 'barSQL':
		barSQL($_POST['arguments'][0], $_POST['arguments'][1]);
	break;

	case 'pieReportSQL':
		pieReportSQL($_POST['arguments'][0], $_POST['arguments'][1]);
	break;
	
	case 'barReportSQL':
		barReportSQL($_POST['arguments'][0], $_POST['arguments'][1]);
	break;

	case 'selectYearPieSQL':
		selectYearPieSQL();
	break;
  
	default:
    		echo json_encode("Problem");
    	break;

}

?>

