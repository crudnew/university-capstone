/*
 * Random Color Generator from: Adam Cole & Peter Mortensen via: https://stackoverflow.com/questions/1484506/random-color-generator (Modified by Chris for more appealing colors)
 */

const PIE = document.getElementById("pieChart");
const BAR = document.getElementById("barChart");

var yearPie = document.getElementById("yearPie");
var neighbourhoodPie = document.getElementById("neighbourhoodPie");


var neighbourhoodBar1 = document.getElementById("neighbourhoodBar1");
var neighbourhoodBar2 = document.getElementById("neighbourhoodBar2");
var yearBar = document.getElementById("yearBar");
var div2NB = document.getElementById("neighbourhoodBar3");
var div3NB = document.getElementById("neighbourhoodBar4");
var div4NB = document.getElementById("neighbourhoodBar5");

var div2 = document.getElementById("neigh2Div");
var div3 = document.getElementById("neigh3Div");
var div4 = document.getElementById("neigh4Div");
var div5 = document.getElementById("neigh5Div");



var prevCountArr = [1];
var prevCountArr2= [1];
var determine = true;
var deetermine2= true;

var prevNBCount = 1;
var prevNBCount2= 1;


/**
 * Adds neighbourhood Divs for Bar Chart
 * PARAMETERS: N/A
 * RETURN: N/A
 */
//For adding and removing neighbourhood Divs for Bar Chart
function addDiv(){
	if(div2.style.display === "none"){
		div2.style.display = "block";
	}
	else if(div3.style.display === "none"){
                div3.style.display = "block";
	}
	else if(div4.style.display === "none"){
                div4.style.display = "block";
        }
	else if(div5.style.display === "none"){
                div5.style.display = "block";
        }
	else{
		alert("Maximum of 5 Neighbourhoods Reached!");
	}
}

/**
 * Removes neighbourhood Divs for Bar Chart
 * PARAMETERS: N/A
 * RETURN: N/A
 */
function removeDiv(){
	if(div5.style.display === "block"){
                div5.style.display = "none";
        }
        else if(div4.style.display === "block"){
                div4.style.display = "none";
        }
	else if(div3.style.display === "block"){
                div3.style.display = "none";
        }
	else if(div2.style.display === "block"){
                div2.style.display = "none";
        }
        else{
                alert("Minimum of 1 Neighbourhood Reached!");
        }
}


/**
 * Ajax function that Selects statement for Pie and bar chart Year filters
 */
$.ajax({
	type: "POST",
	url: 'statsPageSQL.php',
	data: {functionname: 'selectYearPieSQL'},

	success: function (years) {
	var pieYears = JSON.parse(years);
	for(key in pieYears){
		var option1 = document.createElement("option");	
		var option2 = document.createElement("option");
		option1.text = pieYears[key];
		option2.text = pieYears[key];
		yearPie.add(option1);
		yearBar.add(option2);
	}
	}
});

/** 
 * Ajax function that Selects statement for Pie and Bar chart Neighbourhood
 * 
 *
 */
$.ajax({
	type: "POST",
	url: 'statsPageSQL.php',
	data: {functionname: 'selectNeighbourhoodSQL'},

	success: function (neighbourhoods) {
		var Neighbourhoods = JSON.parse(neighbourhoods);
		for(key in Neighbourhoods){
			var option1 = document.createElement("option");
			var option2 = document.createElement("option");
			var option3 = document.createElement("option");
			var option4 = document.createElement("option");
			var option5 = document.createElement("option");
			var option6 = document.createElement("option");
			option1.text = Neighbourhoods[key];
			option2.text = Neighbourhoods[key];
			option3.text = Neighbourhoods[key];
			option4.text = Neighbourhoods[key];
			option5.text = Neighbourhoods[key];
			option6.text = Neighbourhoods[key];
			neighbourhoodPie.add(option1);
			neighbourhoodBar1.add(option2);
			neighbourhoodBar2.add(option3);
			div2NB.add(option4);
			div3NB.add(option5);
			div4NB.add(option6);
		}
	}
});

/**
 * Function for when pie chart confirm button clicked
 * PARAMETERS: N/A
 * RETURN: N/A
 */
function pieClicked(){

	var yearPie = document.getElementById("yearPie");
	var neighbourhoodPie = document.getElementById("neighbourhoodPie");

	var yearPieUser = yearPie.value;
	var neighbourhoodPieUser = neighbourhoodPie.value;
	
	getPieChartInfo(neighbourhoodPieUser, yearPieUser);
}


/**
 * Function for when bar chart confirm button clicked
 * PARAMETERS: N/A
 * RETURN: N/A
 */
function barClicked(){

	var NBList = [];

	var neighbourhoodBar1 = document.getElementById("neighbourhoodBar1");
	var neighbourhoodBar2 = document.getElementById("neighbourhoodBar2");
	var yearBar = document.getElementById("yearBar");
	
	var neighbourhoodBar1User = neighbourhoodBar1.value;
	NBList.push(neighbourhoodBar1User);

	if(div2.style.display === "block"){
		NBList.push(neighbourhoodBar2.value);
        }
        if(div3.style.display === "block"){
                NBList.push(div2NB.value);
        }
	if(div4.style.display === "block"){
                NBList.push(div3NB.value);
        }
	if(div5.style.display === "block"){
		NBList.push(div4NB.value);
        }
		
	var yearBarUser = yearBar.value;
	getBarChartInfo(NBList, yearBarUser);
	
	//getBarChartInfo(neighbourhoodBar2User, yearBarUser);

}


//SQL AJAX FOR PIE CHART
/**
 * Retrieves Information for the Pie Chart via Ajax/SQL call, and appends data to the pie chart
 * PARAMETERS: N/A
 * RETURN: N/A
 */
function getPieChartInfo(){
	var incident_types = [];
	var incident_types2= [];
	var NB = arguments[0];
	var Dates = arguments[1];
	var flag=0;

	var tempYear = parseInt(yearPie.value);
	if (tempYear<2019){
	$.ajax({
	type: "POST",
	url: 'statsPageSQL.php',
	data: {functionname: 'pieSQL', arguments: [ NB, Dates ]},

	success: function (incidents) {
		var Incidents = JSON.parse(incidents);
		if(Incidents == 0){
			alert("No Incidents with Selected Filters!");
			//flag++;
		}
		else{
		for(key2 in Incidents){
			incident_types.push(Incidents[key2]);
		}
		var typeArr = [];
        	var countArr = [];
        
       		var count = 1;
        	for (var i=0; i<incident_types.length; i++){
                	if (incident_types[i] === (incident_types[i+1])){
                        	count++;
                	}
                	else{
                        	countArr.push(count);
				count=1;
                        	typeArr.push(incident_types[i]);
                	}
		}
		//clears previous data		
		for (var i=0; i<prevCountArr.length; i++){
			pieChart.data.labels.pop();
			pieChart.data.datasets[0].backgroundColor.pop();
			pieChart.data.datasets.forEach((dataset)=>{dataset.data.pop();});
			pieChart.update();
		}
	
		//adds new data
		for (var i=0; i<countArr.length; i++){
			pieChart.data.labels.push(typeArr[i]);
			pieChart.data.datasets.forEach((dataset)=>{dataset.backgroundColor.push(getRandomColor(i+1));});
			pieChart.data.datasets.forEach((dataset)=>{dataset.data.push(countArr[i]);});
			pieChart.update();
			
		}

		//used for clearing previous data (prevCountArr is global)
		prevCountArr.length = 0;
		for (var j=0; j<countArr.length; j++){
			prevCountArr[j]=countArr[j];
		}
		}
        }

	}
	);
	}
	
	else{
  	$.ajax({
	type: "POST",
	url: 'statsPageSQL.php',
	data: {functionname: 'pieReportSQL', arguments: [ NB, Dates ]},

	success: function (incidentsR) {
		var IncidentsR = JSON.parse(incidentsR);
		if(IncidentsR == 0){
			alert("No Incidents with Selected Filters!");
			//flag++;
		}
		else{
		for(keyPR in IncidentsR){
			incident_types2.push(IncidentsR[keyPR]);
		}
		var typeArr = [];
                var countArr = [];

                var count = 1;
                for (var i=0; i<incident_types2.length; i++){
                        if (incident_types2[i] === (incident_types2[i+1])){
                                count++;
                        }
                        else{
                                countArr.push(count);
                                count=1;
                                typeArr.push(incident_types2[i]);
                        }
                }
                //clears previous data
                for (var i=0; i<prevCountArr.length; i++){
                        pieChart.data.labels.pop();
                        pieChart.data.datasets[0].backgroundColor.pop();
                        pieChart.data.datasets.forEach((dataset)=>{dataset.data.pop();});
                        pieChart.update();
                }

                //adds new data
                for (var i=0; i<countArr.length; i++){
                        pieChart.data.labels.push(typeArr[i]);
                        pieChart.data.datasets.forEach((dataset)=>{dataset.backgroundColor.push(getRandomColor(i+1));});
                        pieChart.data.datasets.forEach((dataset)=>{dataset.data.push(countArr[i]);});
                        pieChart.update();

                }

                //used for clearing previous data (prevCountArr is global)
                prevCountArr.length = 0;
                for (var j=0; j<countArr.length; j++){
                        prevCountArr[j]=countArr[j];
                }
                }
	}
	});
	}
}



//SQL FOR BAR CHART
/**
 * Retrieves Information for the Bar Chart via Ajax/SQL call, and appends data to the Bar Chart
 * PARAMETERS: N/A
 * RETURN: N/A
 */
function getBarChartInfo(){
	barColorChanger = 0;
	var NBArgCopy = [];
	var flag = 0;

	for (var y=0; y<arguments[0].length; y++){
		NBArgCopy.push(arguments[0][y].slice());
	}
	
	for (var i=0; i<prevNBCount; i++){
		barChart.data.datasets.pop();
	}


	for (var p=0; p<NBArgCopy.length; p++){
        	var newDataSet = {
                	data: [],
                        backgroundColor:[],
                        label: ''
                }
         	barChart.data.datasets.push(newDataSet);
        }
	prevNBCount = NBArgCopy.length;
	

	for (let t=0; t<NBArgCopy.length; t++){
	var NBArray = [];
	NBArray.push(NBArgCopy[t]);


	var tempYear = parseInt(yearBar.value);
	if (tempYear > 2019){
	//New Report function
  	$.ajax({
	type: "POST",
	url: 'statsPageSQL.php',
	data: {functionname: 'barReportSQL', arguments: [ NBArray, arguments[1] ]},

	success: function (countR) {
		amount_incidents = [];
		var CountR = JSON.parse(countR);
		if(CountR == 0){
			alert("No Incidents with Selected Filters");
			//flag++;
		}
		else{
			for(keyBR in CountR){
				amount_incidents.push(CountR[keyBR]);
			}
			var jan=0;
                        var feb=0;
                        var mar=0;
                        var apr=0;
                        var may=0;
                        var jun=0;
                        var jul=0;
                        var aug=0;
                        var sep=0;
                        var oct=0;
                        var nov=0;
                        var dec=0;

                        var monthArr = [];
                        for (var i=0; i<amount_incidents.length; i++){
                                var tempArr = amount_incidents[i][1].split("-");
                                monthArr.push(tempArr[1]);
                        }

                        let intMonthArr = monthArr.map(Number);
                        intMonthArr.sort(function(a,b){
                                return a-b;
                        });

                        //basically, intMonthArr looks like eg. [1,1,1,2,2,3.....]
                        // therefore, 3 incidents in Jan, 2 incidents in Feb, 1 incident in Mar, etc....
                        var count = 1;
                        for (var i=0; i<intMonthArr.length; i++){
                                if(intMonthArr[i] === 1){jan++;}
                                else if (intMonthArr[i] === 2){feb++;}
                                else if (intMonthArr[i] === 3){mar++;}
                                else if (intMonthArr[i] === 4){apr++;}
                                else if (intMonthArr[i] === 5){may++;}
                                else if (intMonthArr[i] === 6){jun++;}
                                else if (intMonthArr[i] === 7){jul++;}
                                else if (intMonthArr[i] === 8){aug++;}
                                else if (intMonthArr[i] === 9){sep++;}
                                else if (intMonthArr[i] === 10){oct++;}
                                else if (intMonthArr[i] === 11){nov++;}
                                else if (intMonthArr[i] === 12){dec++;}

                        }
                        var monthVals = [];
                        monthVals.push(jan);
                        monthVals.push(feb);
                        monthVals.push(mar);
                        monthVals.push(apr);
                        monthVals.push(may);
                        monthVals.push(jun);
                        monthVals.push(jul);
                        monthVals.push(aug);
                        monthVals.push(sep);
                        monthVals.push(oct);
                        monthVals.push(nov);
                        monthVals.push(dec);

                        barChart.data.datasets[t].label = NBArgCopy[t];
                        //adds new data
                        var colorFirst = getRandomColor(1+(t*6.5));
                        for (var i=0; i<12; i++){
                                barChart.data.datasets[t].data.push(monthVals[i]);
                                barChart.data.datasets[t].backgroundColor.push(colorFirst);
                        }
                        barChart.update();
                        //determine=false;
		}
	}
	});
	}
	
		
	else{	
	$.ajax({
		type: "POST",
		url: 'statsPageSQL.php',
		data: {functionname: 'barSQL', arguments: [NBArray, arguments[1]]},

		success: function (count) {

			var amount_incidents = [];
			var Count = JSON.parse(count);
			if(Count == 0){
				alert("No Incidents with Selected Filters");
				//flag++;
			}
			else{
			for(key3 in Count){
				amount_incidents.push(Count[key3]);
			}
			//}
			var jan=0;
			var feb=0;
			var mar=0;
			var apr=0;
			var may=0;
			var jun=0;
			var jul=0;
			var aug=0;
			var sep=0;
			var oct=0;
			var nov=0;
			var dec=0;

			var monthArr = [];
			for (var i=0; i<amount_incidents.length; i++){
				var tempArr = amount_incidents[i][1].split("-");
				monthArr.push(tempArr[1]);
			}
			
			let intMonthArr = monthArr.map(Number);
			intMonthArr.sort(function(a,b){
				return a-b;
			});

			//basically, intMonthArr looks like eg. [1,1,1,2,2,3.....]
			// therefore, 3 incidents in Jan, 2 incideents in Feb, 1 incident in Mar, etc....
			var count = 1;
			for (var i=0; i<intMonthArr.length; i++){
				if(intMonthArr[i] === 1){jan++;}
				else if (intMonthArr[i] === 2){feb++;}
				else if (intMonthArr[i] === 3){mar++;}
				else if (intMonthArr[i] === 4){apr++;}
				else if (intMonthArr[i] === 5){may++;}
				else if (intMonthArr[i] === 6){jun++;}
				else if (intMonthArr[i] === 7){jul++;}
				else if (intMonthArr[i] === 8){aug++;}
				else if (intMonthArr[i] === 9){sep++;}
				else if (intMonthArr[i] === 10){oct++;}
				else if (intMonthArr[i] === 11){nov++;}
				else if (intMonthArr[i] === 12){dec++;}

			}
			var monthVals = [];
			monthVals.push(jan);
			monthVals.push(feb);
			monthVals.push(mar);
			monthVals.push(apr);
			monthVals.push(may);
			monthVals.push(jun);
			monthVals.push(jul);
			monthVals.push(aug);
			monthVals.push(sep);
			monthVals.push(oct);
			monthVals.push(nov);
			monthVals.push(dec);

			barChart.data.datasets[t].label = NBArgCopy[t];
			//adds new data
			var colorFirst = getRandomColor(1+(t*6.5));
			for (var i=0; i<12; i++){
				barChart.data.datasets[t].data.push(monthVals[i]);
				barChart.data.datasets[t].backgroundColor.push(colorFirst);
			}
			barChart.update();
			
			}


		}
	});
	}
	}
	

}

/**
 * Chris's modified version of a random color generater (source at top of file)
 * PARAMETERS: N/A
 * RETURN: c, a color in String format
 */
function getRandomColor(step) {
    var r, g, b;
    var h = step / 30;
    var i = ~~(h * 6);
    var f = h * 6 - i;
    var q = 1 - f;
    switch(i % 6){
        case 0: r = 1; g = f; b = 0; break;
        case 1: r = q; g = 1; b = 0; break;
        case 2: r = 0; g = 1; b = f; break;
        case 3: r = 0; g = q; b = 1; break;
        case 4: r = f; g = 0; b = 1; break;
        case 5: r = 1; g = 0; b = q; break;
    }
    var c = "#" + ("00" + (~ ~(r * 255)).toString(16)).slice(-2) + ("00" + (~ ~(g * 255)).toString(16)).slice(-2) + ("00" + (~ ~(b * 255)).toString(16)).slice(-2);
    return (c);

    }

//data for PIE chart
/*
 * Contains the data for the Pie Chart. This is where the getPieChartInfo function appends to, and this is the format that is used to display the chart
 */
pieData = {
    datasets: [{
        data: [1],
        backgroundColor: ['rgb(255,97,79)']
    }],

    // These labels appear in the legend and in the tooltips when hovering different arcs
    labels: ['Choose a Filter Below']
};



//dummy data for BAR chart
/*
 * Contains the data for the Bar Chart. This is where the getBarChartInfo function appends to, and this is the format that is used to display the chart
 */
barData = {
    datasets: [{
        data: [1,2,3,4,5,6,7,8,9,10,11,12],
        backgroundColor: [
		'rgb(255,97,79)',
		'rgb(255,97,79)',
		'rgb(255,97,79)',
		'rgb(255,97,79)',
		'rgb(255,97,79)',
		'rgb(255,97,79)',
		'rgb(255,97,79)',
		'rgb(255,97,79)',
		'rgb(255,97,79)',
		'rgb(255,97,79)',
		'rgb(255,97,79)',
		'rgb(255,97,79)'
	],
        label: 'Choose a Filter Below'
        
    }],
    


    // These labels appear in the legend and in the tooltips when hovering different arcs
    labels: [
        'January',
        'February',
        'March',
        'April',
        'May',
        'June',
        'July',
        'August',
        'September',
        'October',
        'November',
        'December'
    ]
};


//Displays PIE chart
/**
 * Lets the HTML pieChart = a new Pie Chart, using the pieData above, as the data
 *
 */
let pieChart = new Chart(PIE, {
    type: 'pie',
    data: pieData,
    options: {
        responsive: false,
        title: {
            display: true,
            text: 'Incident Severity for Given Neighbourhood and Year'
        }
    }
});



//Displays BAR chart
/**
 * Lets the HTML barChart = a new Bar Chart, using the barData above, as the data
 */
let barChart = new Chart(BAR, {
    type: 'bar',
    data: barData,
    options: {
        responsive: false,
        title: {
            display: true,
            text: 'Monthly Incident Count for Given Neighbourhood(s) and Year'
        },
	scales: {
	    yAxes: [{
	        ticks: {
		    beginAtZero: true
		}
	    }]
	},
	animation: {
        	duration: 0
    	},
    	hover: {
        	animationDuration: 0
    	},
    	responsiveAnimationDuration: 0
    }
});

