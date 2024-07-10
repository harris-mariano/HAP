@include('partials.header', ['title' => 'adish HAP | User Dashboard'])
@include('partials.menu')
<div class="flex flex-row gap-x-10">
    <div class="flex-none">
      @include('partials.sidebar')
    </div>
    @include('components.ticketstatus')
    <div class="w-full flex flex-col gap-y-5">
      <div class="w-full bg-white p-5 rounded-lg shadow">
          <p class="text-sm font-semibold">Tickets Priority Level</p>
          <div class="py-6" id="donut-chart"></div>
      </div>
      <div class="w-full bg-white p-5 rounded-lg shadow">
          <p class="text-sm font-semibold">Filed Tickets</p>
          <div id="bar-chart"></div>
      </div>
    </div>
</div>
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

const userRequired = {{$userRequired}}
const userLow = {{$userLow}}
const userMedium = {{$userMedium}}
const userHigh = {{$userHigh}}

const requiredPercentage = parseFloat(userRequired / userTickets); 
const lowPercentage = parseFloat(userLow / userTickets); 
const mediumPercentage = parseFloat(userMedium / userTickets); 
const highPercentage = parseFloat(userHigh /userTickets);

const getDonutChartOptions = () => {
  return {
    series: [requiredPercentage, lowPercentage, mediumPercentage, highPercentage],
    colors: ["#FECB9D", "#FEBE82", "#FCA863", "#FB923C"],
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
          size: "80%",
        },
      },
    },
    grid: {
      padding: {
        top: -2,
      },
    },
    labels: ["Required", "Low Priority", "Medium Priority", "High Priority"],
    dataLabels: {
      enabled: false,
    },
    legend: {
      position: "bottom",
      fontFamily: "Inter, sans-serif",
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

const quarterOne = {{$quarterOne}}
const quarterTwo = {{$quarterTwo}}
const quarterThree = {{$quarterThree}}
const quarterFour = {{$quarterFour}}

const departmentOne = {{$departmentOne}}
const departmentTwo = {{$departmentTwo}}
const departmentThree = {{$departmentThree}}
const departmentFour = {{$departmentFour}}

const departmentName = "{{$departmentName}}"

const barChartOptions = {
  series: [
    {
      name: "My Tickets",
      color: "#E88504",
      data: [quarterOne, quarterTwo, quarterThree, quarterFour],
    },
    {
      name: departmentName + " " + "Tickets", 
      data: [departmentOne, departmentTwo, departmentThree, departmentFour],
      color: "#959595",
    }
  ],
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
});
</script>
@include('partials.footer')