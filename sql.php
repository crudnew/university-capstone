



<?php


//Seeting the username, password and database name (not used in all)
//
$servername = "localhost";
$username = "user";
$password = 'G3%DrhG?3tR"gJM5';
$dbname = 'CMPTCAP';

$array=[];


//For the location combobox
//Displays all locations for the filter
function selectEPS_DataLocationSQL() {
  	$connection = mysqli_connect('localhost','user','G3%DrhG?3tR"gJM5','CMPTCAP');
  	$selectQuery = "SELECT DISTINCT `Neighbourhood Description (Occurrence)` as place from EPS_Data order by place";
  	$query_run = mysqli_query($connection, $selectQuery);

	//Running the query and returning the locations
  	if($query_run->num_rows > 0){
		while($row = $query_run->fetch_assoc()){
			  $array[] = $row["place"];
		}
		$connection -> close();
		echo json_encode($array);
	} else {
		$connection -> close();
		echo json_encode(0);
 	 }
}

//These next two are different
//Ones for the EPS table
//Ones for the report crimes


//
//
// SelectioLocationFilterSQL
//
// Returns: All locations that have been filtered with selected crimes
//
// Parameters: NB, Dates, Crimes: list of neighbourhoods selected, list of start and end date and list of crime types
//
function selectLocationFilterSQL($NB, $Dates, $crimes) {
	$sDate = $Dates[0];
	$eDate = $Dates[1];

	$idList = join("','", $crimes);	

	////checks if the list of neighbourhoods is checked as "all" or if one is chosen
	if($NB == "ALL"){
		$selectQuery = "select `latitude`, `longitude`, `Neighbourhood Description (Occurrence)`, `Name`, `Dates`, `Sev` from EPS_Data, Incident_Type where `Dates` > '$sDate' and `Dates` < '$eDate' and EPS_Data.`ITID` = Incident_Type.`ITID` and Incident_Type.`ITID` in ('$idList')";
	}
	else{
		$selectQuery = "select `latitude`, `longitude`, `Neighbourhood Description (Occurrence)`, `Name`, `Dates`, `Sev` from EPS_Data, Incident_Type where `Dates` > '$sDate' and `Dates` < '$eDate' and `Neighbourhood Description (Occurrence)` = '$NB' and EPS_Data.`ITID` = Incident_Type.`ITID` and Incident_Type.`ITID` in ('$idList')";

	}

	$connection = mysqli_connect('localhost','user','G3%DrhG?3tR"gJM5','CMPTCAP');
	$query_run = mysqli_query($connection, $selectQuery);


	if($query_run->num_rows > 0){
		while($row = $query_run->fetch_assoc()){
			$array[] = array($row["longitude"],$row["latitude"],$row["Neighbourhood Description (Occurrence)"],$row["Name"],$row["Dates"],$row["Sev"]);
		}
		$connection -> close();
		echo json_encode($array);
	} else {
		$connection -> close();
		echo json_encode(0);
	}
}


//
// SelectReportFilterSQL
//
// Returns: All locations that have been filtered with selected crime Reports this is with the Reports table
//
// Parameters: NB, Dates, Crimes: list of neighbourhoods selected, list of start and end date and list of crime types
//

function selectReportFilterSQL($NB, $Dates, $crimes) {
	$sDate = $Dates[0];
	$eDate = $Dates[1];

	$idList = join("','", $crimes);	

	if($NB == "ALL"){
		$selectQuery = "select Reports.`Latitude`, Reports.`Longitude`, `NH_Name`, `Name`, `Report_Date`, `Sev`, `Report_Desc` from Reports, Incident_Location, Incident_Type where `Report_Date` > '$sDate' and `Report_Date` < '$eDate' and Reports.`ITID` = Incident_Type.`ITID` and Incident_Type.`ITID` in ('$idList') and Reports.`RID` = Incident_Location.`RID`";
	}
	else{
		$selectQuery = "select Reports.`Latitude`, Reports.`Longitude`, `NH_Name`, `Name`, `Report_Date`, `Sev`, `Report_Desc` from Reports, Incident_Location, Incident_Type where `Report_Date` > '$sDate' and `Report_Date` < '$eDate' and `NH_Name` = '$NB' and Reports.`RID` = Incident_Location.`RID` and Reports.`ITID` = Incident_Type.`ITID` and Incident_Type.`ITID` in ('$idList')";

	}

	$connection = mysqli_connect('localhost','user','G3%DrhG?3tR"gJM5','CMPTCAP');
	$query_run = mysqli_query($connection, $selectQuery);

	if($query_run->num_rows > 0){
		while($row = $query_run->fetch_assoc()){
			$array[] = array($row["Longitude"],$row["Latitude"],$row["NH_Name"],$row["Name"],$row["Report_Date"],$row["Sev"],$row["Report_Desc"]);
		}
		echo json_encode($array);
	} else {
		echo json_encode(0);
	}
	$connection -> close();
}

//These two grab the information from the reports table and EPS table


//
// SelectInfoSQL
//
// Returns: All locations from a certain date at the beginning of the website
//
// Parameters: None
//


function selectInfoSQL() {
	$connection = mysqli_connect('localhost','user','G3%DrhG?3tR"gJM5','CMPTCAP');
	$selectQuery = "select `latitude`, `longitude`, `Neighbourhood Description (Occurrence)`, `Name`, `Dates`, `Sev` from EPS_Data, Incident_Type where `Dates` > '2019-10-01' and EPS_Data.`ITID` = Incident_Type.`ITID`";

	$query_run = mysqli_query($connection, $selectQuery);

	if($query_run->num_rows > 0){
		while($row = $query_run->fetch_assoc()){
			$array[] = array($row["longitude"],$row["latitude"],$row["Neighbourhood Description (Occurrence)"],$row["Name"],$row["Dates"],$row["Sev"]);
		}
		echo json_encode($array);
	} else {
		echo json_encode(0);								     
	}
	$connection -> close();
}


//
// SelectReportInfoSQL
//
// Returns: All locations from a certain date as the webpage refreshes
//
// Parameters: None
//


function selectReportInfoSQL() {
	$connection = mysqli_connect('localhost','user','G3%DrhG?3tR"gJM5','CMPTCAP');
	$selectQuery = "select Reports.`Latitude`, Reports.`Longitude`, `NH_Name`, `Name`, `Report_Date`, `Sev`, `Report_Desc` from Reports, Incident_Location, Incident_Type where `Report_Date` > '2019-10-01' and Reports.`ITID` = Incident_Type.`ITID` and Reports.`RID` = Incident_Location.`RID`";

	$query_run = mysqli_query($connection, $selectQuery);

	if($query_run->num_rows > 0){
		while($row = $query_run->fetch_assoc()){
			$array[] = array($row["Latitude"],$row["Longitude"],$row["NH_Name"],$row["Name"],$row["Report_Date"],$row["Sev"], $row["Report_Desc"]);
		}
		echo json_encode($array);
	} else {
		echo json_encode(0);								     
	}
	$connection -> close();
}



//Switch statement that reads the functionname and calls functions
switch($_POST['functionname']){

  	case 'selectEPS_DataLocationSQL':
    		selectEPS_DataLocationSQL();
    	break;

  	case 'selectReportInfoSQL':
    		selectReportInfoSQL();
    	break;

	case 'selectLocationFilterSQL':
		selectLocationFilterSQL($_POST['arguments'][0], $_POST['arguments'][1], $_POST['arguments'][2]);
	break;
	
	case 'selectReportFilterSQL':
		selectReportFilterSQL($_POST['arguments'][0], $_POST['arguments'][1], $_POST['arguments'][2]);
	break;

	case 'selectInfoSQL':
		selectInfoSQL();
	break;

  	default:
    		echo json_encode("Problem");
    	break;

}

?>
