$(document).ready(function(){
	$.ajax({
		url : "http://localhost/iot/data.php",
		type : "GET",
		success : function(data){
			console.log(data);
			
			var TV = [];
			var Heater = [];
			var Computer = [];
			var Bulb = [];
			var date = [];
			var time = [];
			
			for(var i in data) {
				TV.push(data[i].TV);
				Heater.push(data[i].Heater);
				Computer.push(data[i].Computer);
				Bulb.push(data[i].Bulb);
				date.push(data[i].date);
				time.push(data[i].time);
			}
			
			var chartdata = {
				labels: time,
				datasets: [
					{
						label: "TV",
						fill: false,
						lineTension: 0.1,
						backgroundColor: "rgba(59, 89, 152, 0.75)",
						borderColor: "rgba(59, 89, 152, 1)",
						pointHoverBackgroundColor: "rgba(59, 89, 152, 1)",
						pointHoverBorderColor: "rgba(59, 89, 152, 1)",
						data: TV
					},
					{
						label: "Heater",
						fill: false,
						lineTension: 0.1,
						backgroundColor: "rgba(29, 202, 255, 0.75)",
						borderColor: "rgba(29, 202, 255, 1)",
						pointHoverBackgroundColor: "rgba(29, 202, 255, 1)",
						pointHoverBorderColor: "rgba(29, 202, 255, 1)",
						data: Heater
					},
					{
						label: "Computer",
						fill: false,
						lineTension: 0.1,
						backgroundColor: "rgba(211, 72, 54, 0.75)",
						borderColor: "rgba(211, 72, 54, 1)",
						pointHoverBackgroundColor: "rgba(211, 72, 54, 1)",
						pointHoverBorderColor: "rgba(211, 72, 54, 1)",
						data: Computer
					},
					{
						label: "Bulb",
						fill: false,
						lineTension: 0.1,
						backgroundColor: "rgba(150, 192, 80, 0.75)",
						borderColor: "rgba(150, 192, 80, 1)",
						pointHoverBackgroundColor: "rgba(150, 192, 80, 1)",
						pointHoverBorderColor: "rgba(150, 192, 80, 1)",
						data: Bulb
					}
				]
			};
			
			var ctx = $("#mycanvas");
			
			var LineGraph = new Chart(ctx, {
				type: 'line',
				data: chartdata
			});
			
		},
		error : function(data){
			
		}
	});
});