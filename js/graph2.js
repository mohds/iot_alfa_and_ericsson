$(document).ready(function() {
    var options = {
        chart: {
            renderTo: 'container',
            type: 'spline'
        },
		title: {
			text: 'Energry Consumption Monitor'
		},
		subtitle: {
			text: 'Irregular time data in Highcharts JS'
		},
		xAxis: {
			type: 'datetime',
			dateTimeLabelFormats: { // don't display the dummy year
				month: '%e. %b',
				year: '%b'
			},
			title: {
				text: 'Date'
			}
		},
		yAxis: {
			title: {
				text: 'Snow depth (m)'
			},
			min: 0
		},
		tooltip: {
			headerFormat: '<b>{series.name}</b><br>',
			pointFormat: '{point.x:%e. %b}: {point.y:.2f} m'
		},
		plotOptions: {
			spline: {
				marker: {
					enabled: true
				}
			}
		},
		
        series: [{}]
		
    };
    
    var url =  "http://192.168.1.68/iot/data/json.php?callback=?";
    $.getJSON(url,  function(data) {
        options.series[0].data = data;
		options.series[0].name = "TV";
        var chart = new Highcharts.Chart(options);
    });
});