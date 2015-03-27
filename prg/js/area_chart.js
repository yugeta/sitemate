google.load("visualization", "1", {packages:["corechart"]});
google.setOnLoadCallback(drawChart);
function drawChart() {
	/*
	var data = google.visualization.arrayToDataTable([
	['Year', 'Sales', 'Expenses'],
	['2013',  1000,      400],
	['2014',  1170,      460],
	['2015',  660,       1120],
	['2016',  1030,      540]
	]);

	var options = {
	title: 'Company Performance',
	hAxis: {title: 'Year',  titleTextStyle: {color: '#333'}},
	vAxis: {minValue: 0}
	};

	var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
	chart.draw(data, options);
	*/
	$$LIB.ajax.set({
		query:{
			"php":"area_chart",
			"mode":"load_chart"
		},
		method:"post",
		url:"index.php",
		async:true,
		onSuccess:function(res){

			if(!res){return}

			var json = JSON.parse(res);

			var data = google.visualization.arrayToDataTable(json);

			var options = {
				title: 'Access Report',
				hAxis: {title: 'Day',  titleTextStyle: {color: '#333'}},
				vAxis: {minValue: 0}
			};

			var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
			chart.draw(data, options);
		}
	});
}
