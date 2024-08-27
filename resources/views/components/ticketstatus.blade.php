  <div class="w-1/4 bg-white p-5 rounded-lg shadow">
      <div class="flex flex-row justify-between">
        <div class="flex flex-row items-center">
          <p class="text-sm font-semibold">Tickets Statuses</p>
        <div id="question-svg">
          <svg data-popover-target="chart-info" data-popover-placement="bottom" class="w-3.5 h-3.5 text-gray-500 hover:text-gray-900 cursor-pointer ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm0 16a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3Zm1-5.034V12a1 1 0 0 1-2 0v-1.418a1 1 0 0 1 1.038-.999 1.436 1.436 0 0 0 1.488-1.441 1.501 1.501 0 1 0-3-.116.986.986 0 0 1-1.037.961 1 1 0 0 1-.96-1.037A3.5 3.5 0 1 1 11 11.466Z"/>
          </svg>
        </div>
        </div>
        <button id="radial-download" class="flex justify-end">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
          </svg>
        </button>
    </div>
    <div id="chart-info" role="tooltip" class="absolute z-10 invisible inline-block text-sm transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 w-1/4">
      <div class="p-3 space-y-2">
        <p>These are the description of ticket categories and their corresponding color:</p>
        <div class="w-full bg-open opacity-80 rounded-md p-2 text-white">
          <p><span class="font-medium">New Tickets: </span>These are the tickets that have not yet been assigned to an employee.</p>
        </div>
        <div class="w-full bg-in-progress opacity-80 rounded-md p-2 text-white">
          <p><span class="font-medium">In Progress Tickets: </span>These are the tickets that have been assigned on an employee.</p>
        </div>
        <div class="w-full bg-resolved opacity-80 rounded-md p-2 text-white">
          <p><span class="font-medium">Resolved Tickets: </span>These are the tickets that has been solved with documentation.</p>
        </div>
        <div class="w-full bg-closed opacity-80 rounded-md  p-2 text-white">
          <p><span class="font-medium">Closed Tickets: </span>These are the tickets or issues that is not occurring anymore.</p>
        </div>
      </div>
    </div>
    <div class="flex flex-row gap-x-4 mt-5">
          <div class="w-full h-24 bg-all-tickets bg-opacity-80 rounded-lg text-sm font-medium text-center flex flex-col justify-center items-center">
            <p class="text-white text-4xl">{{$userTickets}}</p>
            <p>All Tickets</p>
        </div>
        </div>
        <div class="flex flex-row gap-x-4 mt-5">
          <div class="w-24 h-24 bg-open bg-opacity-80 rounded-lg text-sm font-medium text-center flex flex-col justify-center items-center">
            <p class="text-white text-4xl">{{$userNew}}</p>
            <p>New</p>
          </div>
            <div class="w-24 h-24 bg-in-progress bg-opacity-80 rounded-lg text-sm font-medium text-center flex flex-col justify-center items-center">
              <p class="text-white text-4xl">{{$userInProgress}}</p>
              <p>In Progress</p>
            </div>
        </div>
        <div class="flex flex-row gap-x-4 mt-5">
            <div class="w-24 h-24 bg-resolved bg-opacity-80 rounded-lg text-sm font-medium text-center flex flex-col justify-center items-center">
              <p class="text-white text-4xl">{{$userResolved}}</p>
              <p>Resolved</p>
          </div>
          <div class="w-24 h-24 bg-closed bg-opacity-80 rounded-lg text-sm font-medium text-center flex flex-col justify-center items-center">
            <p class="text-white text-4xl">{{$userClosed}}</p>
            <p>Closed</p>
        </div>
        </div>
    <div class="py-6" id="radial-chart"></div>
  </div>

    <script>
      //save tickets statuses
document.getElementById('radial-download').addEventListener('click', function() {
            html2canvas(document.querySelector('#radial-chart')).then(canvas => {
                let link = document.createElement('a');
                link.href = canvas.toDataURL('image/png'); 
                link.download = 'tickets-statuses.png'; 
                link.click();
            });
        });
    </script>
