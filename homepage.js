var map;
var e = new Date();
var markers = [];
var sDate = "2019-10-01";
var eDateValue = "";
var day = e.getDate().toString();
var month = (e.getMonth()+1).toString();
var year = e.getFullYear().toString();
eDateValue = year.concat("-0");
eDateValue = eDateValue.concat(month);
eDateValue = eDateValue.concat("-");
eDateValue = eDateValue.concat(day);


/*
 *Description: Initalizes thee map with the starting markers
 *Parameters: NONE
 *Return: NONE
 */
function initMap(){
	var icons = [];
	
	//sets the starting location to Edmonton
	var location = {lat: 53.544, lng: -113.491};
	map = new google.maps.Map(document.getElementById("map"), {
		zoom: 11,
		center: location
	});


	//For the legnd in the map
	map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(document.getElementById('legend'));
	var bluesrc = "http://maps.google.com/mapfiles/ms/icons/blue-dot.png";              
	var greensrc = "http://maps.google.com/mapfiles/ms/icons/green-dot.png";
	var yellowsrc = "http://maps.google.com/mapfiles/ms/icons/yellow-dot.png";
	var redsrc = "http://maps.google.com/mapfiles/ms/icons/red-dot.png";
	icons.push(bluesrc);
	icons.push(greensrc);
	icons.push(yellowsrc);
	icons.push(redsrc);
	var legend = document.getElementById('legend');
	
	//populates the map with the correct images and description
	var div1 = document.createElement('div');
	div1.innerHTML = '<img src="' + bluesrc + '"> ' + "Least severe";
	legend.appendChild(div1);
	var div2 = document.createElement('div');
	div2.innerHTML = '<img src="' + greensrc + '"> ' + "Midly severe";
	legend.appendChild(div2);
	var div3 = document.createElement('div');
	div3.innerHTML = '<img src="' + yellowsrc + '"> ' + "Moderately severe";
	legend.appendChild(div3);
	var div4 = document.createElement('div');
	div4.innerHTML = '<img src="' + redsrc + '"> ' + "Most severe";
	legend.appendChild(div4);
	var div5 = document.createElement('div');
	div5.innerHTML = '<label id="legendMsg">' + "Showing:\n From: " + sDate +"\nTo:"+ eDateValue;
	legend.appendChild(div5);
}

//On Page refresh
$(document).ready(function(){

	//Setting filters for location Pins
  	var row = [];
	$.ajax({
      		type: "POST",
      		url: 'sql.php',
      		data: {functionname: 'selectEPS_DataLocationSQL'},//, arguments: []},

      		success: function (result) {
		var response = JSON.parse(result);
        	for(key in response){
			var comboBox = document.getElementById("location");
			var option = document.createElement("option");
			option.text = response[key];
			comboBox.add(option);
        	}
      		}
  	});


	//Ajax statement gets the incidents from the database and then creates markers
	//for the map
    	initMap();
    	var gps = [];
	$.ajax({
		type: "POST",	
		url: 'sql.php',
		data: {functionname: 'selectReportInfoSQL'},
		success: function (result5) {            
			var response5 = JSON.parse(result5); 
			var x = 0;
			for (key5 in response5){
				gps.push(response5[key5]);
			}
			for (x in gps){
				createMarkers(gps[x]);
			}
		}
	});


	
	
	
	//gets the incidents from the second table in the database and then creates 
	//markers 
	$.ajax({
	type: "POST",
	url: 'sql.php',
	data: {functionname: 'selectInfoSQL'},
	success: function (result2) {
		var response2 = JSON.parse(result2);
		for (key2 in response2){
			gps.push(response2[key2]);	
		}
		for (x in gps){
			createMarkers(gps[x]);
		}
	}
  });
});

/*
 *Descritption: Creates markers from the longtitudes and latitudes and populates 
 *	the marker pop up with the descrition, crime type and neighborhood
 *Parameters: lst - A list of elements gotten from the database
 *Returns: NONE
 */
function createMarkers(lst){
	//gets the longitude and latitude
	var lat1 = parseFloat(lst[0]);
	var lng1 = parseFloat(lst[1]);
	
	//formats the string to be put in the pop uip window
	var windowCont2 = "<h1>"+lst[3]+"</h1>"+
		"<div>Neighborhood: " + lst[2] + "</div>"+
		"<div>Incident happened on: "+lst[4]+"</div>";
	//creates the marker
	var loc = {lat: lng1, lng: lat1};
	var marker = new google.maps.Marker({
		position: loc,  
		map: map
	});
	
	//depending on the serverity of the crime it assigns a certian marker
	switch(lst[5]){
		case '1':
			marker.setIcon("http://maps.google.com/mapfiles/ms/icons/blue-dot.png");              
			break;
		case '2':
			marker.setIcon("http://maps.google.com/mapfiles/ms/icons/green-dot.png");
			break;
		case '3':
			marker.setIcon("http://maps.google.com/mapfiles/ms/icons/yellow-dot.png");
			break;
		case '4':
			marker.setIcon("http://maps.google.com/mapfiles/ms/icons/red-dot.png");
			break;
		default:
			marker.setIcon("http://maps.google.com/mapfiles/ms/icons/blue-dot.png");
			break;
	}
	//if the is a description it puts it in the pop up if not then it displays "undefined"
	if (lst[6] != ' '){
		windowCont2 += "<div>Incident Description: " + lst[6] + "<div>";
	}
	else{
		windowCont2 += "<div>Incident Description: undefined<div>";
	}
	
	//adds the marker to a list and then assigns it a pop up window 
	markers.push(marker);
	var infoWindow = new google.maps.InfoWindow({});		
	google.maps.event.addListener(marker, 'click', function(content){
		return function(){
			infoWindow.setContent(content);
			infoWindow.open(map, this);
		}
	} (windowCont2)  );

}

/*
 *Description: sets all markers on the map
 *Parameters: map - a map object to set the markers on
 *Returns: NONE
 */
function setMapOnAll(map){
	for (let i = 0; i < markers.length; i++){
		markers[i].setMap(map);
	}
}

/*
 *Description: Deletes the markers on the map
 *Parameters: NONE
 *Returns: NONE
 */
function deleteMarker(){
	setMapOnAll(null);
	markers = [];
}

/*
 *Description: checks to see if the check boxes are checked
 *Parameters: NONE
 *returns: crimeList - a list of the checked crime boxes 
 */
function isChecked(){

	//gets all the check boxes by ID
	var assaultCheck = document.getElementById("assault");
        var BreakEnterCheck = document.getElementById("breakAndEnter");
        var homicideCheck = document.getElementById("homicide");
        var robberyCheck = document.getElementById("robbery");
        var stalking = document.getElementById("Stalking/Harassment");
        var theftofVehicleCheck = document.getElementById("theftOfVehicle");
        var theftfromVehicleCheck = document.getElementById("theftFromVehicle");
	var hate = document.getElementById("hateCrime");
	var arson = document.getElementById("arson");
	var fraud = document.getElementById("fraud");
        var susActivity = document.getElementById("suspiciousActivity");	
	
	var crimeList = [];
	

	//change this deoending on what is clicked
	if (assaultCheck.checked == true) {
		crimeList.push("4"); //incident type 4 Assault
	}
	if (BreakEnterCheck.checked == true) {
		crimeList.push("5"); //incident Type 5 Break and Enter
	}
	if (homicideCheck.checked == true) {
		crimeList.push("0"); // incident type 0 homicide
        }
	if (robberyCheck.checked == true) {
                crimeList.push("2");// incident type 2 robbery
        }
	if (stalking.checked == true) {
                crimeList.push("7");// incident type 7 stalking
	}
	if (theftofVehicleCheck.checked == true) {
                crimeList.push("1");// incident type 1 theft of vehicle
        }
        if (theftfromVehicleCheck.checked == true) {
                crimeList.push("3");// incident type 3 theft from vehicle
	}
	if (susActivity.checked == true) {
                crimeList.push("6");// incident type 6 suspicious activity
	}
	if (arson.checked == true) {
                crimeList.push("8");// incident type 8 arson
	}
        if (fraud.checked == true) {
                crimeList.push("9");// incident type 9 fraud
        }
        if (hate.checked == true) {
                crimeList.push("10");// incident type 10 hate crime
	}
	else{
           
        }
	
	return crimeList;
}

/*
 *Description: Checks to see what the date selected is
 *Parameters: NONE
 *Returns: dates - the start and end date of the input boxes
 */
function datesClicked(){
	var dates = [];
	var d = new Date();
	splitSDate = [];
	splitEDate = [];
	
	//gets the start date by selection or default value
	var startDateFilter = document.getElementById("startDate");
	var sDateValue = startDateFilter.value;
	if(sDateValue.length == 0){
		sDateValue = "2019/10/01";
	}
	else{
		splitSDate = sDateValue.split("/");
		sDateValue = "";
		sDateValue = sDateValue.concat(splitSDate[2]);
		sDateValue = sDateValue.concat("/");
		sDateValue = sDateValue.concat(splitSDate[0]);
		sDateValue = sDateValue.concat("/");
		sDateValue = sDateValue.concat(splitSDate[1]);

	}
	var start = sDateValue.replace("/","-");
	var startDate = start.replace("/","-");
	dates.push(startDate);
	
	//gets the end date by selection or by default value
	var endDateFilter = document.getElementById("endDate");
	var eDateValue = endDateFilter.value;
	if(eDateValue.length == 0){
		eDateValue = "";
		var day = d.getDate().toString();
		var month = (d.getMonth()+1).toString();
		var year = d.getFullYear().toString();
		eDateValue = year.concat("/0");
		eDateValue = eDateValue.concat(month);
		eDateValue = eDateValue.concat("/");
		eDateValue = eDateValue.concat(day);
	}
	else{
		splitEDate = eDateValue.split("/");
		eDateValue = "";
		eDateValue = eDateValue.concat(splitEDate[2]);
		eDateValue = eDateValue.concat("/");
		eDateValue = eDateValue.concat(splitEDate[0]);
		eDateValue = eDateValue.concat("/");
		eDateValue = eDateValue.concat(splitEDate[1]);
	}
	var end = eDateValue.replace("/","-");
	var endDate = end.replace("/","-");
	dates.push(endDate);

	return dates;
}

/*
 *Description: selects the neighborhood from the combo box 
 *Parameters: NONE
 *Returns: NB - the neighborhood name selected by the user
 */
function locationPicked(){
	
	var value = document.getElementById("location");
	var NB = value.options[value.selectedIndex].value;
	if (NB == "ALL"){
		return NB;
	}
	else{
		return NB;
	}
}

/*
 *Description: When the filter button is clicked it gets all the user input 
 *	and then searches the database for the soecified information
 *Parameters: NONE
 Retunrs: NONE
 */
function buttonClicked(){
	//deletes all the current markers from the map
	deleteMarker(); 	

	//instanciating the variables 
	var crimeList = [];
	var NB;
	var dates = [];
	var allGPS = [];
	var flag = 0;

	//checking what options the user wants to filter by
	idList = isChecked();
	NB = locationPicked();
	dates = datesClicked();
	sDate = dates[0];
	eDateValue = dates[1];

	//assigning the selected date to the pegend on the map
	var oldDate = document.getElementById('legendMsg');
	oldDate.remove();
	var div5 = document.createElement('div');
	div5.innerHTML = '<label id="legendMsg">' + "Showing:\n From: " + sDate +"\nTo:"+ eDateValue;
	legend.appendChild(div5);

	//ajax statment to get the incidents from the EPS table specified by the users input	
	$.ajax({
		type: "POST",	
		url: 'sql.php',
		data: {functionname: 'selectLocationFilterSQL', arguments: [NB, dates, idList]},
		success: function (result3) {            
			var response3 = JSON.parse(result3); 
			var x = 0;
			//error checking to make sure there is data as well as creates the markers
			if (response3 == 0){
				flag = flag + 1;
			}
			else{
				for (key3 in response3){
					allGPS.push(response3[key3]);
				}
				for (x in allGPS){
					createMarkers(allGPS[x]);
				}
			}
		}
	});
	
	//ajax statment to get the new incidents from the database and create markers from them
	$.ajax({
		type: "POST",	
		url: 'sql.php',
		data: {functionname: 'selectReportFilterSQL', arguments: [NB, dates, idList]},
		success: function (result4) {            
			var response4 = JSON.parse(result4); 
			var x = 0;
			//error checks to make sure the length is not zero and then creates the markers
			if (response4 == 0){
				flag = flag + 1;
			}
			else{
				for (key4 in response4){
					allGPS.push(response4[key4]);
					console.log(response4[key4]);
				}
				for (x in allGPS){
					createMarkers(allGPS[x]);
				}
			}
		}
	});	
	if(flag == 2){
		alert("No Incidents with Selected Filters!")	
	}
	//resets the flag
	flag = 0;
}



