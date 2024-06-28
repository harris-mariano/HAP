@include('partials.header', ['title' => 'adish HAP | Customer Dashboard'])
@include('partials.menu')
<div class="flex flex-row gap-x-10">
    <div class="flex-none">
        @include('partials.sidebar')
    </div>
   @include('components.ticketstatus')
   @include('components.knowledgebase')
   
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

  const getChartOptions = () => {
  return {
    series: [50, 25, 16.67, 8.33],
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
  const chart = new ApexCharts(document.querySelector("#radial-chart"), getChartOptions());
  chart.render();
}

</script>
@include('partials.footer')