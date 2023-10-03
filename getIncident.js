
/*
 *Description: ajax request to get the crime types from the database and then populate
 *	the combo box with them
 *Parameters: NONE
 *Returns: NONE
 */
$(document).ready(function(){
	var row = [];
	$.ajax({
		type: "POST",
		url: 'getIncidentSQL.php',
		data: {functionname: 'selectIncidentSQL'},

		success: function (result) {
			var response = JSON.parse(result);
			for(key in response){
				var comboBox = document.getElementById("iType");
				var option = document.createElement("option");
				option.text = response[key];
				comboBox.add(option);
			}
		}
	});
});

/*
 *Description: This is the procudure that is ran when the submit button is clicked.
 *Parameters: NONE
 *Returns: NONE
 */
function submitClicked(){

	var d = new Date();
	var rDate = "";

	//sets the date for the date picker just in case there is no user input
	var iDate = document.getElementById("start").value
	if(iDate.length == 0){
		var iDate = "";
		var day = d.getDate().toString();
		var month = (d.getMonth()+1).toString();
		var year = d.getFullYear().toString();
		iDate = year.concat("-");
		iDate = iDate.concat(month);
		iDate = iDate.concat("-");
		iDate = iDate.concat(day);
		
	}
	//gets the incidents and person description and makes sure there is some input
	var incidentDesc = document.getElementById("incidentDesc").value;
	if (incidentDesc.length == 0){
		incidentDesc = '\0';
	}
	var personDesc = document.getElementById("personDesc").value;
	if (personDesc.length == 0){
		personDesc = '\0';
	}

	//gets the lat and long from storage, set in reportPage.js
	var lat = localStorage.getItem("lat");
	var lng = localStorage.getItem("lng");
	var iType = document.getElementById("iType").value;

	//gets the date to be inserted into the database
	var day = d.getDate().toString();
	var month = (d.getMonth()+1).toString();
	var year = d.getFullYear().toString();
	rDate = year.concat("-");
	rDate = rDate.concat(month);
	rDate = rDate.concat("-");
	rDate = rDate.concat(day);

	//gets the image and user id
	var img = document.getElementById("img").value;
	if (img.length == 0){
		img = '\0';
	}
	var userId = document.getElementById("uId").value;

	//sets as un-verified
	var verified = 0;

	//ajax statement to insert everything into the database 
	$.ajax({
		type: "POST",
		url: 'getIncidentSQL.php',
		data: {functionname: 'insertReportSQL', arguments: [rDate, incidentDesc, iDate, img, personDesc, verified, userId, iType, lat, lng]},
		
		success: function (result) {
			//get all the selections and then insert into database
			console.log(result);

		}

	});


	//closes the window 1 second after button is clicked. If there is no timeout the insert doesnt work.
	setTimeout(function(){
		self.close();
	}, 1000);

}
