<div class="sm:ml-64 w-full flex flex-row gap-x-5 bg-custom-gray p-5">
    <div class="w-1/4 bg-white p-5 rounded-lg shadow">
      <div class="flex flex-row gap-y-1 items-center">
        <p class="text-sm font-semibold">Tickets Statuses</p>
        <div id="question-svg">
          <svg data-popover-target="chart-info" data-popover-placement="bottom" class="w-3.5 h-3.5 text-gray-500 hover:text-gray-900 cursor-pointer ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm0 16a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3Zm1-5.034V12a1 1 0 0 1-2 0v-1.418a1 1 0 0 1 1.038-.999 1.436 1.436 0 0 0 1.488-1.441 1.501 1.501 0 1 0-3-.116.986.986 0 0 1-1.037.961 1 1 0 0 1-.96-1.037A3.5 3.5 0 1 1 11 11.466Z"/>
          </svg>
        </div>
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
            <p class="text-white text-4xl">{{$allTickets}}</p>
            <p>All Tickets</p>
        </div>
        </div>
        <div class="flex flex-row gap-x-4 mt-5">
          <div class="w-24 h-24 bg-open bg-opacity-80 rounded-lg text-sm font-medium text-center flex flex-col justify-center items-center">
            <p class="text-white text-4xl">{{$openTickets}}</p>
            <p>New</p>
          </div>
            <div class="w-24 h-24 bg-in-progress bg-opacity-80 rounded-lg text-sm font-medium text-center flex flex-col justify-center items-center">
              <p class="text-white text-4xl">{{$inProgressTickets}}</p>
              <p>In Progress</p>
            </div>
        </div>
        <div class="flex flex-row gap-x-4 mt-5">
            <div class="w-24 h-24 bg-resolved bg-opacity-80 rounded-lg text-sm font-medium text-center flex flex-col justify-center items-center">
              <p class="text-white text-4xl">{{$resolvedTickets}}</p>
              <p>Resolved</p>
          </div>
          <div class="w-24 h-24 bg-closed bg-opacity-80 rounded-lg text-sm font-medium text-center flex flex-col justify-center items-center">
            <p class="text-white text-4xl">{{$closedTickets}}</p>
            <p>Closed</p>
        </div>
        </div>
    <div class="py-6" id="radial-chart"></div>
    </div>
