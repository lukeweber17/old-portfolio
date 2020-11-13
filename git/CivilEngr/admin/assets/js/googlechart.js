
google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Year', 'X', 'Y'],
          ['0',  1000,      400],
          ['100',  1170,      460],
          ['200',  660,       1120],
          ['300',  1030,      540]
        ]);

        var options = {
          title: 'Cement Graph',
		  chartArea: {
			  width: '70%',
			  height: '70%'
		  },
		  height: 383,
		  width: 600,
          hAxis: {
			title: 'PSI',  
			titleTextStyle: {
				color: '#333'
			}
		},
          vAxis: {minValue: 0}
        };

        var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }