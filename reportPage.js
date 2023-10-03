var map;
var marker;

/*
 *Description: On document start up initializes the map
 *Parameters: NONE
 *Returns: NONE
 */
$(document).ready(function(){
	initMap();
});


/*
 *Description: function to initialize the map
 *Parameters: NONE
 *Returns: NONE
 */
function initMap(){
	//Sets the map location to Edmonton
	var location = {lat: 53.544, lng: -113.491};
	map = new google.maps.Map(document.getElementById("map"), {
		zoom: 11,
		center: location
	});
	
	//adds an on click listener for map click
	map.addListener("click", (event) => {
		addMarkerClick(event.latLng);
		
		//confirms the the correct location was selected
		var ans = window.confirm("would you like to add an incident to this location?");
		//if correct location is selected, a new window will open and longitude and latitude 
		//will get put in storage
		if(ans){
			console.log("picked yes");
			var myWindow = open("getIncident.php", "", "width=500, height=450");
			var lat = marker.getPosition().lat();
			var lng = marker.getPosition().lng();
			myWindow.onload = function(){
				localStorage.setItem("lat", lat);
				localStorage.setItem("lng", lng);
			}
		}
		//else marker is removed and they can select a new location
		else{
			console.log("picked no");
			marker.setMap(null);
		}
	});
}

/*
 *Description: Used for getting the current location of the user. 
 	Only works with https.
 *Parameters: NONE
 *Returns: NONE
 *NOTE: not used anywhere in the website at this time. can be enabled when https is set up
 */
function currentLocationClick(){
	navigator.geolocation.getCurrentPosition(function(location) {
		  console.log(location.coords.latitude);
		  console.log(location.coords.longitude);
		  console.log(location.coords.accuracy);
	});
}

/*
 *Description: Adds a marker to the map on click
 *Parameteres: location - longitude and latitude of the clicked postioin on the map
 *Returns: NONE
 */
function addMarkerClick(location){
	marker = new google.maps.Marker({
		position: location,
		map: map,
	});
}

