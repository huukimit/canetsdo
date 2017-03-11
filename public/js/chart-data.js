var lastw = JSON.parse($('#lastweek').val());
var thisw = JSON.parse($('#thisweek').val());
var lastWeek = [];
var thisWeek = [];
for(var i = 0, day; day = lastw[i]; i++) {
	lastWeek[i] = day;
}
for(var i = 0, day; day = thisw[i]; i++) {
	thisWeek[i] = day;
}
var lineChartData = {
		labels : ["Monday","Tueday","Wenesday","Thirday","Friday","Saturday","Sunday"],
		datasets : [
			{
				label: "My First dataset",
				fillColor : "rgba(220,220,220,0.2)",
				strokeColor : "rgba(220,220,220,1)",
				pointColor : "rgba(220,220,220,1)",
				pointStrokeColor : "#fff",
				pointHighlightFill : "#fff",
				pointHighlightStroke : "rgba(220,220,220,1)",
				data : lastWeek
			},
			{
				label: "My Second dataset",
				fillColor : "rgba(48, 164, 255, 0.2)",
				strokeColor : "rgba(48, 164, 255, 1)",
				pointColor : "rgba(48, 164, 255, 1)",
				pointStrokeColor : "#fff",
				pointHighlightFill : "#fff",
				pointHighlightStroke : "rgba(48, 164, 255, 1)",
				data : thisWeek
			}
			
		]

	}
		
window.onload = function(){
	var chart1 = document.getElementById("line-chart").getContext("2d");
	window.myLine = new Chart(chart1).Line(lineChartData, {
		responsive: true
	});
};