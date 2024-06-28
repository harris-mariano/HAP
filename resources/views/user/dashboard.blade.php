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
  });

   const getRadialChartOptions = () => {
  return {
    series: [25, 25, 25, 25],
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

const getDonutChartOptions = () => {
  return {
    series: [50, 25, 25],
    colors: ["#FB923C", "#FCA863", "#FEBE82"],
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
                return value + "%"
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
    labels: ["High Priority", "Medium Priority", "Low Priority"],
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
          return value + "%"
        },
      },
    },
    xaxis: {
      labels: {
        formatter: function (value) {
          return value  + "%"
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


const barChartOptions = {
  series: [
    {
      name: "My Tickets",
      color: "#E88504",
      data: ["20", "25", "15", "35", "10", "20"],
    },
    {
      name: "HRAD Tickets",
      data: ["50", "50", "35", "50", "20", "40"],
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
    categories: ["January", "February", "March", "April", "May", "June"],
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

</script>
@include('partials.footer')