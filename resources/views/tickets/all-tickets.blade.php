@include('partials.header', ['title' => 'adish HAP | All Tickets'])
@include('partials.menu')
<div class="flex flex-row gap-x-10 pt-24">
    <div class="flex-none">
      @include('partials.sidebar')
    </div>
    <div class="sm:ml-64 w-full min-h-screen flex flex-col gap-x-5 bg-custom-gray p-5">
        @include('components.messages')
        <div class="w-full bg-white p-5 rounded-lg shadow">
            <p class="text-sm font-semibold">My Filed Tickets</p>
            @if ($userTickets->count() <= 0) 
            <div class="h-screen flex items-center justify-center">
                <div class="text-center">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-14 mx-auto">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                  </svg>
                  <p class="mt-2 text-sm font-medium">No filed tickets yet</p>
                </div>
              </div>
              @else
            <div class="relative flex items-center mt-5">
                <input type="text" id="searchInput" placeholder="Type a title here" class="bg-gray-100 p-2 pr-10 text-sm rounded-sm w-full">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="absolute right-3 h-5 w-5">
                  <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
            </div>
            <div class="flex flex-row justify-end gap-x-3 mt-5 text-xs">
                <div class="flex flex-row gap-x-1 mt-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75" />
                      </svg>
                    <p class="font-medium">Filter by</p>
                </div>
                <div class="flex flex-col w-28">
                    <button id="statusButton" class="flex items-center justify-between p-1.5 rounded-sm border-gray-600 border-[1px]">Ticket Status<span><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                      </svg></span></button>
                    <ul id="ticketStatus" class="bg-white hidden absolute z-10 w-28 mt-10 shadow">
                    <li class="w-full">
                    <div class="flex items-center ps-1">
                        <input id="allStatus" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded">
                        <label for="allStatus" class="w-full py-1.5 ms-2">Select All</label>
                    </div>
                    </li>
                    <li class="w-full">
                        <div class="flex items-center ps-1">
                            <input id="new" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded">
                            <label for="new" class="w-full py-1.5 ms-2">New</label>
                        </div>
                    </li>
                    <li class="w-full">
                        <div class="flex items-center ps-1">
                            <input id="inprogress" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded">
                            <label for="inprogress" class="w-full py-1.5 ms-2">In Progress</label>
                        </div>
                    </li>
                    <li class="w-full">
                        <div class="flex items-center ps-1">
                            <input id="resolved" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded">
                            <label for="resolved" class="w-full py-1.5 ms-2">Resolved</label>
                        </div>
                    </li>
                    <li class="w-full">
                        <div class="flex items-center ps-1">
                            <input id="closed" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded">
                            <label for="closed" class="w-full py-1.5 ms-2">Closed</label>
                        </div>
                    </li>
                    </ul>
                </div>
                <div class="flex flex-col w-28">
                    <button id="priorityButton" class="flex items-center justify-between p-1.5 w-28 rounded-sm border-gray-600 border-[1px]">Priority Level<span><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                      </svg></span></button>  
                    <ul id="priorityLevel" class="bg-white hidden absolute z-10 w-28 mt-10 shadow">
                        <li class="w-full">
                        <div class="flex items-center ps-1">
                            <input id="allPriority" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded">
                            <label for="allPriority" class="w-full py-1.5 ms-2">Select All</label>
                        </div>
                        </li>
                        <li class="w-full">
                            <div class="flex items-center ps-1">
                                <input id="required" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded">
                                <label for="required" class="w-full py-1.5 ms-2">Required</label>
                            </div>
                        </li>
                        <li class="w-full">
                            <div class="flex items-center ps-1">
                                <input id="low" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded">
                                <label for="low" class="w-full py-1.5 ms-2">Low Priority</label>
                            </div>
                        </li>
                        <li class="w-full">
                            <div class="flex items-center ps-1">
                                <input id="medium" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded">
                                <label for="medium" class="w-full py-1.5 ms-2">Medium Priority</label>
                            </div>
                        </li>
                        <li class="w-full">
                            <div class="flex items-center ps-1">
                                <input id="high" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded">
                                <label for="high" class="w-full py-1.5 ms-2">High Priority</label>
                            </div>
                        </li>
                        </ul>
                </div>
                <div class="flex flex-row items-center bg-gray-300 rounded-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 ml-3 -mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                      </svg>
                      <button id="clearButton" class="p-1.5 w-16 text-gray-800 font-medium">Reset</button>  
                </div>           
            </div>
            <div class="relative overflow-x-auto mt-5">
                <table id="ticketsTable"  class="w-full text-sm text-left rtl:text-right">
                    <thead class="text-xs text-gray-700 uppercase border-b border-t">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Date
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Title
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Department Assigned
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Employee Assigned
                            </th>
                            <th scope="col" class="px-6 py-3">
                               Ticket Status
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Priority Level
                             </th>
                             <th scope="col" class="px-6 py-3">
                                Action
                             </th>
                        </tr>
                    </thead>
                    <tbody>
                    @auth('user')
                    @foreach($userTickets as $ticket)
                    <tr class="border-b">
                        <td class="px-6 py-4">{{ $ticket->created_at->format('F d, Y') }}</td>
                        <td class="px-6 py-4">{{ $ticket->title }}</td>
                        <td class="px-6 py-4">{{ $ticket->department->name }}</td>
                        <td class="px-6 py-4">{{ $ticket->employee->first_name }} {{ $ticket->employee->last_name }}</td>
                        <td class="px-6 py-4">
                            @if ($ticket->status->category == 'New')
                                <span class="inline-block bg-open rounded-full py-1.5 w-full text-white text-center">{{ $ticket->status->category }}</span>
                            @elseif ($ticket->status->category == 'In Progress')
                                <span class="inline-block bg-in-progress rounded-full py-1.5 w-full text-white text-center">{{ $ticket->status->category }}</span>
                            @elseif ($ticket->status->category == 'Resolved')
                                <span class="inline-block bg-resolved rounded-full py-1.5 w-full text-white text-center">{{ $ticket->status->category }}</span>
                            @elseif ($ticket->status->category == 'Closed')
                                <span class="inline-block bg-closed rounded-full py-1.5 w-full text-white text-center">{{ $ticket->status->category }}</span>
                            @else
                                {{ $ticket->status->category }}
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if ($ticket->priority->category == 'Required')
                                <span class="inline-block bg-gray-400 rounded-full py-1.5 w-full text-white text-center">{{ $ticket->priority->category }}</span>
                            @elseif ($ticket->priority->category == 'Low')
                                <span class="inline-block bg-low rounded-full py-1.5 w-full text-white text-center">{{ $ticket->priority->category }}</span>
                            @elseif ($ticket->priority->category == 'Medium')
                                <span class="inline-block bg-medium rounded-full py-1.5 w-full text-white text-center">{{ $ticket->priority->category }}</span>
                            @elseif ($ticket->priority->category == 'High')
                                <span class="inline-block bg-all-tickets rounded-full py-1.5 w-full text-white text-center">{{ $ticket->priority->category }}</span>
                            @else
                                {{ $ticket->priority->category }}
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('tickets.show', ['ticket' => $ticket->id]) }}" class="p-2 font-medium text-in-progress rounded-sm hover:bg-in-progress hover:text-white">View</a>
                        </td>
                    </tr>
                    @endforeach
                    @endauth
                    </tbody>
                </table>

                <div class="mt-5">
                    {{ $userTickets->links() }}
                </div>

            </div>
            @endif
            
      </div>
    </div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const statusButton = document.getElementById('statusButton');
        const ticketStatus = document.getElementById('ticketStatus');

        const priorityButton = document.getElementById('priorityButton');
        const priorityLevel = document.getElementById('priorityLevel');
        
        statusButton.addEventListener('click', function() {
            ticketStatus.classList.toggle('hidden');
        });

        priorityButton.addEventListener('click', function () {
            priorityLevel.classList.toggle('hidden'); 
        })

        const allPriorityCheckbox = document.getElementById('allPriority');
        const otherPriorityCheckboxes = document.querySelectorAll('#required, #low, #medium, #high');
        let checkedPriorities = [];

        allPriorityCheckbox.addEventListener('change', function() {
            const isChecked = this.checked;

            otherPriorityCheckboxes.forEach(function(checkbox) {
                checkbox.checked = isChecked;
                updatePriorityArray(checkbox.id, isChecked);
            });
            console.log(checkedPriorities);
        });

        otherPriorityCheckboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                updatePriorityArray(this.id, this.checked);
                if (!this.checked) {
                    allPriorityCheckbox.checked = false;
                }
                else {
            allPriorityCheckbox.checked = Array.from(otherPriorityCheckboxes).every(checkbox => checkbox.checked);
            }
            console.log(checkedPriorities);
        filterTable();
            });
        });

        function updatePriorityArray(id, isChecked) {
            if (isChecked && !checkedPriorities.includes(id)) {
                checkedPriorities.push(id);
            } else if (!isChecked && checkedPriorities.includes(id)) {
                checkedPriorities = checkedPriorities.filter(item => item !== id);
            } 
        }

        const allStatusCheckbox = document.getElementById('allStatus');
        const otherStatusCheckboxes = document.querySelectorAll('#new, #inprogress, #resolved, #closed');
        let checkedStatuses = [];

        allStatusCheckbox.addEventListener('change', function() {
            const isChecked = this.checked;

            otherStatusCheckboxes.forEach(function(checkbox) {
                checkbox.checked = isChecked;
                updateStatusArray(checkbox.id, isChecked);
            });
            console.log(checkedStatuses);
            filterTable();
        });

        otherStatusCheckboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                updateStatusArray(this.id, this.checked);
                if (!this.checked) {
            allStatusCheckbox.checked = false;
        } else {
            allStatusCheckbox.checked = Array.from(otherStatusCheckboxes).every(checkbox => checkbox.checked);
        }
        console.log(checkedStatuses);
        filterTable();
            });
        });

        function updateStatusArray(id, isChecked) {
            if (isChecked && !checkedStatuses.includes(id)) {
                checkedStatuses.push(id);
            } else if (!isChecked && checkedStatuses.includes(id)) {
                checkedStatuses = checkedStatuses.filter(item => item !== id);
            } 
        }

        const searchInput = document.getElementById('searchInput');
        const table = document.getElementById('ticketsTable').getElementsByTagName('tbody')[0];

        searchInput.addEventListener('input', filterTable);

        function filterTable() {
            const searchQuery = searchInput.value.trim().toLowerCase();
            const selectedStatuses = checkedStatuses.map(s => s.toLowerCase());
            const selectedPriorities = checkedPriorities.map(p => p.toLowerCase());

            Array.from(table.rows).forEach(function(row) {
                const fullPriority = row.cells[5].textContent.trim().toLowerCase();
                const priority = extractPriorityKeyword(fullPriority);

                const fullStatus = row.cells[4].textContent.trim().toLowerCase(); 
                console.log("full_status", fullStatus);
                const status = extractStatusKeyword(fullStatus); 

                const title = row.cells[1].textContent.trim().toLowerCase();

                const priorityMatch = selectedPriorities.length === 0 || selectedPriorities.includes(priority.toLowerCase());
                const statusMatch = selectedStatuses.length === 0 || selectedStatuses.includes(status);
                const titleMatch = title.includes(searchQuery);

                if (statusMatch && titleMatch && priorityMatch) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        function extractPriorityKeyword(priorityString) {
        if (priorityString.includes("required")) {
            return "required";
        } else if (priorityString.includes("high")) {
            return "high";
        } else if (priorityString.includes("medium")) {
            return "medium";
        } else if (priorityString.includes("low")) {
            return "low";
        }
        return "";
        }   

        function extractStatusKeyword(statusString) {
            if (statusString.includes("new")) {
                return "new";
            }
            else if (statusString.includes("resolved")) {
                return "resolved";
            }
            else if (statusString.includes("closed")) {
                return "closed";
            }
            else if (statusString.includes("in progress")) {
                return "inprogress";
            }
            return "";
        }

        function resetFilters() {
        const checkboxes = document.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = false;
        });

        searchInput.value = '';

        Array.from(table.rows).forEach(function(row) {
            row.style.display = '';
        });

        checkedStatuses = [];
        checkedPriorities = [];

        ticketStatus.classList.add('hidden');
        priorityLevel.classList.add('hidden');

        filterTable();
        }

        const clearButton = document.getElementById('clearButton');
        const checkboxes = document.querySelectorAll('input[type="checkbox"]');

        clearButton.addEventListener('click', function() {
        resetFilters();
    });
    });
</script>
@include('partials.footer')