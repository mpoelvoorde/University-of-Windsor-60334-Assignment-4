
// This, according to Stack Overflow, is like using $(document).ready(...) without using jQuery:
// Source: https://stackoverflow.com/questions/799981/document-ready-equivalent-without-jquery
document.addEventListener("DOMContentLoaded", function(event) { 
  
	// Do the introductory Google chart load stuff:
	google.charts.load('current', {'packages':['corechart']});
	google.charts.setOnLoadCallback(drawChart);
	
	function drawChart() {
		
		// Get data from dummy "<p>" element from PHP code
		var dataString = document.getElementById('data').innerHTML;
		
		// 'eval' converts string to array (reference: https://stackoverflow.com/questions/13630014/convert-string-to-a-multidimensional-array):
		var data = google.visualization.arrayToDataTable(eval(dataString));
		
		// Options for data:
		var options = {'title' : 'Book Distribution By Category' , 'width' : 550, 'height' : 400};
		
		// Display pie chart:
		var chart = new google.visualization.PieChart(document.getElementById('piechart'));
		chart.draw(data, options);
	}

});