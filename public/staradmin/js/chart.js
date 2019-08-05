$(function () {
  /* ChartJS */
  
  var ChartColor = ["#5D62B4", "#54C3BE", "#EF726F", "#F9C446", "rgb(93.0, 98.0, 180.0)", "#21B7EC", "#04BCCC"];
var primaryColor = getComputedStyle(document.body).getPropertyValue('--primary');
var secondaryColor = getComputedStyle(document.body).getPropertyValue('--secondary');
var successColor = getComputedStyle(document.body).getPropertyValue('--success');
var warningColor = getComputedStyle(document.body).getPropertyValue('--warning');
var dangerColor = getComputedStyle(document.body).getPropertyValue('--danger');
var infoColor = getComputedStyle(document.body).getPropertyValue('--info');
var darkColor = getComputedStyle(document.body).getPropertyValue('--dark');
var lightColor = getComputedStyle(document.body).getPropertyValue('--light');
if ($('body').hasClass("dark-theme")) {
  var chartFontcolor = '#b9c0d3';
  var chartGridLineColor = '#383e5d';

} else {
  var chartFontcolor = '#6c757d';
  var chartGridLineColor = 'rgba(0,0,0,0.08)';
}



if ($('canvas').length) {
  Chart.defaults.global.tooltips.enabled = false;
  Chart.defaults.global.defaultFontColor = '#354d66';
  Chart.defaults.global.defaultFontFamily = '"Poppins", sans-serif';
  Chart.defaults.global.tooltips.custom = function (tooltipModel) {
    // Tooltip Element
    var tooltipEl = document.getElementById('chartjs-tooltip');

    // Create element on first render
    if (!tooltipEl) {
      tooltipEl = document.createElement('div');
      tooltipEl.id = 'chartjs-tooltip';
      tooltipEl.innerHTML = "<table></table>";
      document.body.appendChild(tooltipEl);
    }

    // Hide if no tooltip
    if (tooltipModel.opacity === 0) {
      tooltipEl.style.opacity = 0;
      return;
    }

    // Set caret Position
    tooltipEl.classList.remove('above', 'below', 'no-transform');
    if (tooltipModel.yAlign) {
      tooltipEl.classList.add(tooltipModel.yAlign);
    } else {
      tooltipEl.classList.add('no-transform');
    }

    function getBody(bodyItem) {
      return bodyItem.lines;
    }

    // Set Text
    if (tooltipModel.body) {
      var titleLines = tooltipModel.title || [];
      var bodyLines = tooltipModel.body.map(getBody);

      var innerHtml = '<thead>';

      titleLines.forEach(function (title) {
        innerHtml += '<tr><th>' + title + '</th></tr>';
      });
      innerHtml += '</thead><tbody>';

      bodyLines.forEach(function (body, i) {
        var colors = tooltipModel.labelColors[i];
        var style = 'background:' + colors.borderColor;
        style += '; border-color:' + colors.borderColor;
        style += '; border-width: 2px';
        var span = '<span style="' + style + '"></span>';
        innerHtml += '<tr><td>' + span + body + '</td></tr>';
      });
      innerHtml += '</tbody>';

      var tableRoot = tooltipEl.querySelector('table');
      tableRoot.innerHTML = innerHtml;
    }

    // `this` will be the overall tooltip
    var position = this._chart.canvas.getBoundingClientRect();

    // Display, position, and set styles for font
    tooltipEl.style.opacity = 1;
    tooltipEl.style.position = 'absolute';
    tooltipEl.style.left = position.left + window.pageXOffset + tooltipModel.caretX + 'px';
    tooltipEl.style.top = position.top + window.pageYOffset + tooltipModel.caretY + 'px';
    tooltipEl.style.fontFamily = tooltipModel._bodyFontFamily;
    tooltipEl.style.fontSize = tooltipModel.bodyFontSize + 'px';
    tooltipEl.style.fontStyle = tooltipModel._bodyFontStyle;
    tooltipEl.style.padding = tooltipModel.yPadding + 'px ' + tooltipModel.xPadding + 'px';
    tooltipEl.style.pointerEvents = 'none';
  }
  Chart.defaults.global.legend.labels.fontStyle = "italic";
  Chart.defaults.global.tooltips.intersect = false;
}


  if ($("#registerstackedbarChart").length) {
    var stackedbarChartCanvas = $("#registerstackedbarChart").get(0).getContext("2d");
    var stackedbarChart = new Chart(stackedbarChartCanvas, {
      type: 'bar',
      data: {
        //labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul"],
		labels: labels,
		
		
        datasets: [{
            label: member_label,
            backgroundColor: ChartColor[0],
            borderColor: ChartColor[0],
            borderWidth: 1,
            data: reguser
          }
		  /*,
          {
            label: "Mobile",
            backgroundColor: ChartColor[1],
            borderColor: ChartColor[1],
            borderWidth: 1,
            data: [3, 5, 6, 3, 1, 2, 3]
          }*/
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: true,
        legend: false,
        categoryPercentage: 0.5,
        stacked: true,
        layout: {
          padding: {
            left: 0,
            right: 0,
            top: 0,
            bottom: 0
          }
        },
        scales: {
          xAxes: [{
            display: true,
            scaleLabel: {
              display: true,
              labelString: regsiter_date,
              fontColor: '#334344',
              fontSize: 12,
              lineHeight: 2
            },
            ticks: {
              fontColor: '#334344',
              stepSize: 3,
              min: 0,
              max: 15,
              autoSkip: true,
              autoSkipPadding: 15,
              maxRotation: 0,
              maxTicksLimit: 10
            },
            gridLines: {
              display: false,
              drawBorder: false
            //  color: chartGridLineColor,
            //  zeroLineColor: chartGridLineColor
            }
          }],
          yAxes: [{
            display: true,
            scaleLabel: {
              display: true,
              labelString:  member_label,
              fontColor: chartFontcolor,
              fontSize: 12,
              lineHeight: 2
            },
            ticks: {
              fontColor: chartFontcolor,
              stepSize: 10,
              min: 0,
              max: 50,
              autoSkip: true,
              autoSkipPadding: 15,
              maxRotation: 0,
              maxTicksLimit: 10
            },
            gridLines: {
              drawBorder: false,
              color: chartGridLineColor,
              zeroLineColor: chartGridLineColor
            }
          }]
        },
        legend: {
          display: false
        },
        legendCallback: function (chart) {
          var text = [];
          text.push('<div class="chartjs-legend"><ul>');
          for (var i = 0; i < chart.data.datasets.length; i++) {
            console.log(chart.data.datasets[i]); // see what's inside the obj.
            text.push('<li>');
            text.push('<span style="background-color:' + chart.data.datasets[i].backgroundColor + '">' + '</span>');
            text.push(chart.data.datasets[i].label);
            text.push('</li>');
          }
          text.push('</ul></div>');
          return text.join("");
        },
        elements: {
          point: {
            radius: 0
          }
        }
      }
    });
    document.getElementById('stacked-bar-traffic-legend').innerHTML = stackedbarChart.generateLegend();
  }
});