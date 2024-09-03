@include('partials.header', ['title' => 'adish HAP | User Dashboard'])
@include('partials.menu')
<div class="flex flex-row gap-x-10 pt-20">
    <div class="flex-none">
      @include('partials.sidebar')
    </div>     
    <div class="sm:ml-64 w-full flex flex-row gap-x-5 bg-custom-gray p-5">
      @include('components.ticketstatus')
      <div class="w-full flex flex-col gap-y-5">
        <div id="priority" class="w-full bg-white p-5 rounded-lg shadow">
          <div class="flex flex-row justify-between" title="Save as PNG">
            <p class="text-sm font-semibold">Tickets Priority Level</p>
            <button id="donut-download">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
              </svg>
            </button>
            </div>
          <div class="py-6" id="donut-chart"></div>
        </div>
        <div class="w-full bg-white p-5 rounded-lg shadow">
          <div class="flex flex-row justify-between" title="Save as PNG">
          <p class="text-sm font-semibold">Filed Tickets</p>
          <button id="bar-download">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
            </svg>
          </button>
          </div>
          <div id="bar-chart"></div>
        </div>
      </div>
    </div>
    
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    const icon = document.getElementById('question-svg');
    const popover = document.getElementById('chart-info');

    icon.addEventListener('mouseenter', function() {
      popover.classList.remove('invisible'); 
      popover.classList.add('opacity-100'); 
    });

    icon.addEventListener('mouseleave', function() {
      popover.classList.add('invisible'); 
      popover.classList.remove('opacity-100'); 
    });

  const userTickets = {{$userTickets}}
  const userNew = {{$userNew}}
  const userInProgress = {{$userInProgress}}
  const userResolved = {{$userResolved}}
  const userClosed = {{$userClosed}}

  const newPercentage = parseFloat((userNew / userTickets) * 100).toFixed(2); 
  const progressPercentage = parseFloat((userInProgress / userTickets) * 100).toFixed(2); 
  const resolvedPercentage = parseFloat((userResolved / userTickets) * 100).toFixed(2); 
  const closedPercentage = parseFloat((userClosed /userTickets) * 100).toFixed(2);

  const ticketPercentages = [newPercentage, progressPercentage, resolvedPercentage, closedPercentage];
  const getRadialChartOptions = () => {
  return {
    series: [newPercentage,progressPercentage,resolvedPercentage,closedPercentage],
    colors: ["rgba(234, 179, 8, 0.8)",
            "rgba(59, 130, 246, 0.8)",   
            "rgba(34, 197, 94, 0.8)",    
            "rgba(239, 68, 68, 0.8)"],
    chart: {
      height: "380px",
      width: "100%",
      type: "radialBar",
      sparkline: {
        enabled: true,
      },
    },
    plotOptions: {
      radialBar: {
        track: {
          background: '#E5E7EB',
        },
        dataLabels: {
          show: false,
        },
        hollow: {
          margin: 0,
          size: "10%",
        }
      },
    },
    labels: ["New", "In Progress", "Resolved", "Closed"],
    legend: {
      show: true,
      position: "bottom",
      fontFamily: "Inter, sans-serif",
      formatter: function(seriesName, opts) {
        let percentage = ticketPercentages[opts.seriesIndex];
        if (isNaN(percentage)) {
          percentage = 0;
        }
      return `${seriesName}: ${percentage.toFixed(2)}%`;
      }
    },
    tooltip: {
      enabled: true,
      x: {
        show: false,
      },
    },
    yaxis: {
      show: false,
      labels: {
        formatter: function (value) {
          return value + '%';
        }
      }
    }
  }
}

if (document.getElementById("radial-chart") && typeof ApexCharts !== 'undefined') {
  const chart = new ApexCharts(document.querySelector("#radial-chart"), getRadialChartOptions());
  chart.render();
}
else {
  console.error("Chart element or ApexCharts library not found.");
}

const userLow = {{$userLow}}
const userMedium = {{$userMedium}}
const userHigh = {{$userHigh}}

const lowPercentage = parseFloat(userLow / userTickets); 
const mediumPercentage = parseFloat(userMedium / userTickets); 
const highPercentage = parseFloat(userHigh /userTickets);

const priorityPercentages = [lowPercentage, mediumPercentage, highPercentage];
const getDonutChartOptions = () => {
  return {
    series: [lowPercentage, mediumPercentage, highPercentage],
    colors: ["#FEBE82", "#FCA863", "#FB923C"],
    chart: {
      height: 320,
      width: "100%",
      type: "donut",
    },
    stroke: {
      colors: ["transparent"],
      lineCap: "",
    },
    plotOptions: {
      pie: {
        donut: {
          labels: {
            show: true,
            name: {
              show: true,
              fontFamily: "Inter, sans-serif",
              offsetY: 20,
            },
            value: {
              show: true,
              fontFamily: "Inter, sans-serif",
              offsetY: -20,
              formatter: function (value) {
                return (value * 100).toFixed(2) + "%";
              },
            },
          },
          size: "70%",
        },
      },
    },
    grid: {
      padding: {
        top: -2,
      },
    },
    labels: ["Low Priority", "Medium Priority", "High Priority"],
    dataLabels: {
      enabled: false,
      dropShadow: {
        enabled: false,
      },

    },
    legend: {
      show: true,
      position: "bottom",
      fontFamily: "Inter, sans-serif",
      formatter: function(seriesName, opts) {
        let percentage = priorityPercentages[opts.seriesIndex] * 100;
        if (isNaN(percentage)) {
          percentage = 0;
        }
      return `${seriesName}: ${percentage.toFixed(2)}%`;
      }
    },
    yaxis: {
      labels: {
        formatter: function (value) {
          return (value * 100).toFixed(2) + "%";
        },
      },
    },
    xaxis: {
      labels: {
        formatter: function (value) {
          return (value * 100).toFixed(2) + "%";
        },
      },
      axisTicks: {
        show: false,
      },
      axisBorder: {
        show: false,
      },
    },
  }
}

if (document.getElementById("donut-chart") && typeof ApexCharts !== 'undefined') {
  const chart = new ApexCharts(document.getElementById("donut-chart"), getDonutChartOptions());
  chart.render();
}

const departmentData = @json($departmentData); 

const barChartOptions = {
  series: departmentData,
  chart: {
    sparkline: {
      enabled: false,
    },
    type: "bar",
    width: "100%",
    height: 400,
    toolbar: {
      show: false,
    }
  },
  fill: {
    opacity: 1,
  },
  plotOptions: {
    bar: {
      horizontal: true,
      columnWidth: "100%",
      borderRadiusApplication: "end",
      borderRadius: 6,
      dataLabels: {
        position: "top",
      },
    },
  },
  legend: {
    show: true,
    position: "bottom",
  },
  dataLabels: {
    enabled: false,
  },
  tooltip: {
    shared: true,
    intersect: false,
    formatter: function (value) {
      return value
    }
  },
  xaxis: {
    labels: {
      show: true,
      style: {
        fontFamily: "Inter, sans-serif",
        cssClass: 'text-xs font-normal fill-gray-500'
      },
      formatter: function(value) {
        return value
      }
    },
    categories: ["Q1", "Q2", "Q3","Q4"],
    axisTicks: {
      show: false,
    },
    axisBorder: {
      show: false,
    },
  },
  yaxis: {
    labels: {
      show: true,
      style: {
        fontFamily: "Inter, sans-serif",
        cssClass: 'text-xs font-normal fill-gray-500'
      }
    }
  },
  grid: {
    show: true,
    strokeDashArray: 4,
    padding: {
      left: 2,
      right: 2,
      top: -20
    },
  },
  fill: {
    opacity: 1,
  }
}

if(document.getElementById("bar-chart") && typeof ApexCharts !== 'undefined') {
  const chart = new ApexCharts(document.getElementById("bar-chart"), barChartOptions);
  chart.render();
}

//save filed tickets
document.getElementById('bar-download').addEventListener('click', function() {
            html2canvas(document.querySelector('#bar-chart')).then(canvas => {
                let link = document.createElement('a');
                link.href = canvas.toDataURL('image/png'); 
                link.download = 'filed-tickets.png'; 
                link.click();
            });
        });

//save priority level
document.getElementById('donut-download').addEventListener('click', function() {
            html2canvas(document.querySelector('#donut-chart')).then(canvas => {
                let link = document.createElement('a');
                link.href = canvas.toDataURL('image/png'); 
                link.download = 'priority-level.png'; 
                link.click();
            });
        });
});



</script>
@include('partials.footer')