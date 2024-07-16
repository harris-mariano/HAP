@include('partials.header', ['title' => 'adish HAP | Individual Ticket'])
@include('partials.menu')
<div class="flex flex-row gap-x-10">
    <div class="flex-none">
      @include('partials.sidebar')
    </div>
    <div class="sm:ml-64 w-full flex flex-col gap-y-5 bg-custom-gray p-5">
        <div class="w-full bg-white p-5 rounded-lg shadow">
            <form action="{{ route('tickets.update', ['ticket' => $ticket->id]) }}" method="POST">
              @method('PUT')
              @csrf
            <div class="grid grid-cols-2 gap-x-24 px-2 py-3">
                <div class="flex flex-col">
                    <label for="status" class="text-sm font-medium">Ticket Status:</label>
                    @auth('customer')
                    @if ($ticket->status->category == 'New')
                        <div id="status" class="bg-open mt-2 text-white mb-7 w-full bg-[#EAEAEA] p-2 text-sm rounded-sm">{{ $ticket->status->category }}</div>
                    @elseif ($ticket->status->category == 'In Progress')
                        <div id="status" class="bg-in-progress mt-2 text-white mb-7 w-full bg-[#EAEAEA] p-2 text-sm rounded-sm">{{ $ticket->status->category }}</div>
                    @elseif ($ticket->status->category == 'Resolved')
                        <div id="status" class="bg-resolved mt-2 text-white mb-7 w-full bg-[#EAEAEA] p-2 text-sm rounded-sm">{{ $ticket->status->category }}</div>
                    @elseif ($ticket->status->category == 'Closed')
                        <div id="status" class="bg-closed mt-2 text-white mb-7 w-full bg-[#EAEAEA] p-2 text-sm rounded-sm">{{ $ticket->status->category }}</div>
                    @else
                        {{ $ticket->status->category }}
                    @endif
                    @elseauth('user')
                    @if(auth('user')->user()->department_id == $ticket->department_id)
                    <select name="status_id" id="status" class="mt-2 mb-7 w-full border-[1px] border-black p-2 text-sm rounded-sm" required>
                            <option value="" {{ $ticket->status->id == "" ? 'selected' : '' }}>Select the ticket status </option>
                            <option value="1" {{ $ticket->status->id == "1" ? 'selected' : '' }}>New</option>
                            <option value="2" {{ $ticket->status->id == "2" ? 'selected' : '' }}>In Progress</option>
                            <option value="3" {{ $ticket->status->id == "3" ? 'selected' : '' }}>Resolved</option>
                            <option value="4" {{ $ticket->status->id == "4" ? 'selected' : '' }}>Closed</option>
                        </select>
                        @error('department')
                        <p class="text-xs text-red-700 mt-2">{{$message}}</p>
                        @enderror
                    @else
                    @if ($ticket->status->category == 'New')
                        <div id="status" class="bg-open mt-2 text-white mb-7 w-full bg-[#EAEAEA] p-2 text-sm rounded-sm">{{ $ticket->status->category }}</div>
                    @elseif ($ticket->status->category == 'In Progress')
                        <div id="status" class="bg-in-progress mt-2 text-white mb-7 w-full bg-[#EAEAEA] p-2 text-sm rounded-sm">{{ $ticket->status->category }}</div>
                    @elseif ($ticket->status->category == 'Resolved')
                        <div id="status" class="bg-resolved mt-2 text-white mb-7 w-full bg-[#EAEAEA] p-2 text-sm rounded-sm">{{ $ticket->status->category }}</div>
                    @elseif ($ticket->status->category == 'Closed')
                        <div id="status" class="bg-closed mt-2 text-white mb-7 w-full bg-[#EAEAEA] p-2 text-sm rounded-sm">{{ $ticket->status->category }}</div>
                    @else
                        {{ $ticket->status->category }}
                    @endif
                    @endif
                    @endauth
                </div>
                <div class="flex flex-col">
                    <label for="date" class="text-sm font-medium">Last Updated on:</label>
                    <div id="date" class="mt-2 mb-7 w-full bg-[#EAEAEA] p-2 text-sm rounded-sm">{{ $ticket->updated_at->format('F d, Y') }}</div>
                </div>
                <div class="flex flex-col">
                    <label for="department" class="text-sm font-medium">Department Assigned:</label>
                    @auth('customer')
                    <div id="department" class="mt-2 mb-7 w-full bg-[#EAEAEA] p-2 text-sm rounded-sm">{{ $ticket->department->name }}</div>
                    @elseauth('user')
                    @if(auth('user')->user()->department_id == $ticket->department_id)
                        <select name="department_id" id="department" class="mt-2 mb-7 w-full border-[1px] border-black p-2 text-sm rounded-sm" required>
                            <option value="" {{ $ticket->department->id == "" ? 'selected' : '' }}>Select the department</option>
                            <option value="1" {{ $ticket->department->id == "1" ? 'selected' : '' }}>HRAD</option>
                            <option value="2" {{ $ticket->department->id == "2" ? 'selected' : '' }}>Team Banana</option>
                        </select>
                        @error('department')
                        <p class="text-xs text-red-700 mt-2">{{$message}}</p>
                        @enderror
                    @else
                    <div id="department" class="mt-2 mb-7 w-full bg-[#EAEAEA] p-2 text-sm rounded-sm">{{ $ticket->department->name }}</div>
                    @endif
                    @endauth
                </div>
                <div class="flex flex-col">
                    <label for="employee" class="text-sm font-medium">Employee Assigned:</label>
                    @auth('customer')
                    <div id="employee" class="mt-2 mb-7 w-full bg-[#EAEAEA] p-2 text-sm rounded-sm">{{ $ticket->employee->first_name }} {{ $ticket->employee->last_name }}</div>
                    @elseauth('user')
                    @if(auth('user')->user()->department_id == $ticket->department_id)
                        <select name="employee_id" id="employee" class="mt-2 mb-7 w-full border-[1px] border-black p-2 text-sm rounded-sm" required>
                            <option value="" {{$ticket->employee->id == "" ? 'selected' : ''}}>Select the employee</option>
                            @foreach($employees as $employee)
                            <option value="{{$employee->id}}" {{$ticket->employee->id == $employee->id ? 'selected' : ''}}>{{$employee->first_name}} {{$employee->last_name}}</option>
                            @endforeach
                        </select>
                        @error('employee')
                        <p class="text-xs text-red-700 mt-2">{{$message}}</p>
                        @enderror
                    @else
                    <div id="employee" class="mt-2 mb-7 w-full bg-[#EAEAEA] p-2 text-sm rounded-sm">{{ $ticket->employee->first_name }} {{ $ticket->employee->last_name }}</div>
                    @endif
                    @endauth
                </div>
                <div class="flex flex-col">
                    <label for="title" class="text-sm font-medium">Title:</label>
                    <div id="title" class="mt-2 mb-5 w-full bg-[#EAEAEA] p-2 text-sm rounded-sm">{{ $ticket->title }}</div>
                </div>
                <div class="flex flex-col">
                    <label for="priority" class="text-sm font-medium">Priority Level:</label>
                    @auth('customer')
                    <div id="priority" class="mt-2 mb-5 w-full bg-[#EAEAEA] p-2 text-sm rounded-sm">{{ $ticket->priority->category }}</div>
                    @elseauth('user')
                    @if(auth('user')->user()->department_id == $ticket->department_id)
                    <select name="priority_id" id="priority" class="mt-2 mb-7 w-full border-[1px] border-black p-2 text-sm rounded-sm" required>
                        <option value="" {{ $ticket->priority->id == "" ? 'selected' : '' }}>Select the priority level</option>
                        <option value="1" {{ $ticket->priority->id == "1" ? 'selected' : '' }}>Required</option>
                        <option value="2" {{ $ticket->priority->id == "2" ? 'selected' : '' }}>Low Priority</option>
                        <option value="3" {{ $ticket->priority->id == "3" ? 'selected' : '' }}>Medium Priority</option>
                        <option value="4" {{ $ticket->priority->id == "4" ? 'selected' : '' }}>High Priority</option>
                    </select>
                    @error('department')
                    <p class="text-xs text-red-700 mt-2">{{$message}}</p>
                    @enderror
                    @else
                    <div id="priority" class="mt-2 mb-5 w-full bg-[#EAEAEA] p-2 text-sm rounded-sm">{{ $ticket->priority->category }}</div>
                    @endif
                    @endauth
                </div>
      </div> 
      <div class="flex flex-col px-2 h-auto mb-7">
        <label for="description" class="text-sm font-medium mb-2">Description:</label>
        <div class="ql-editor mt-1 w-full h-auto bg-[#EAEAEA] p-2 text-sm rounded-sm">{!! $ticket->description !!}</div>
      </div>
      <div class="flex flex-col px-2 mb-7">
        <label for="attachments" class="text-sm font-medium mb-2">Attachments:</label>
        <div class="flex flex-col space-y-2">
            @if (count($ticket->attachments) > 0 )
            @foreach ($ticket->attachments as $attachment)
                <a href="{{ route('show.attachment', ['id' => $attachment->id]) }}" target="_blank" class="underline text-in-progress text-sm">{{ $attachment->file_name }}</a>
            @endforeach
            @else 
            <label for="attachments" class="flex flex-col items-center justify-center w-full h-30 border-2 border-gray-300 rounded-lg cursor-pointer mt-2">
                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 ">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                      </svg>
                    <p class="mt-1 text-sm font-medium">No attached files</p>
                </div>
            </label>
            @endif
        </div>
        @auth('user')
        @if(auth('user')->user()->department_id == $ticket->department_id)
        <div class="flex justify-end">
            <button type="submit" class="w-32 p-2 mt-5 bg-custom-orange rounded-sm text-white text-sm font-bold">Update Ticket</button>
        </div>
        @endif
        @endauth
    </form>
    </div>
    </div>

    <div class="w-full bg-white p-5 rounded-lg shadow">
        <p class="text-sm font-semibold">Discussions ({{$ticket->comments->count()}})</p>
        <div class="mt-2">
            <form action="{{route('comment.create', ['id' => $ticket->id])}}" method="POST" enctype="multipart/form-data">
            @csrf
            <textarea name="comment" id="comment" rows="5" class="border w-full text-sm px-4 py-2" placeholder="Write comment..." required></textarea>
            @error('comment')
            <p class="text-xs text-red-700 mt-2">{{$message}}</p>
            @enderror
            <label for="photo" class="flex flex-col ml-3 -mt-9 cursor-pointer">
                <div class="flex flex-row items-center gap-x-2 ">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 text-in-progress">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                      </svg>                      
                    <p id="file-name" class="text-sm text-in-progress">Add attachment</p>
                </div>
                <input id="photo" name="photo" type="file" class="hidden" accept=".jpg, .jpeg, .png, .mov, .mp4"/>
                @error('photo')
                <p class="text-xs text-red-700 mt-5">{{$message}}</p>
                @enderror
            </label>
            <div class="flex justify-end">
                <button type="submit" class="w-32 p-2 mt-5 bg-custom-orange rounded-sm text-white text-sm font-bold">Post Comment</button>
            </div>
         </form>
        </div>
        @foreach($ticket->comments as $comment)
        <div class="border-b p-3 mt-5">
            <div class="flex flex-row items-center justify-between">
                <div class="flex flex-row items-center gap-x-2">
                    @if ($comment->customer && isset($comment->customer->profile_picture))
                    <img src="{{ asset('storage/' . $comment->customer->profile_picture) }}" class="w-8 h-8" alt="Profile Picture" />
                    @elseif ($comment->user && isset($comment->user->profile_picture))
                        <img src="{{ asset('storage/' . $comment->user->profile_picture) }}" class="w-8 h-8" alt="Profile Picture" />
                    @else
                        <img src="{{ asset('images/user.png') }}" class="w-8 h-8" alt="Default Profile Picture" />
                    @endif
                    <p class="text-sm font-medium">
                        @if ($comment->customer)
                            {{ $comment->customer->first_name }} {{ $comment->customer->last_name }}
                        @elseif ($comment->user)
                            {{ $comment->user->first_name }} {{ $comment->user->last_name }}
                        @endif
                    </p>
                </div>
                <p class="text-sm text-gray-500">{{ $comment->updated_at->format('F d, Y') }}</p>
            </div>
            <div class="flex flex-col gap-y-2 py-3 px-10 text-sm">
                <p>{{$comment->comment}}</p>
                @foreach ($comment->attachments as $attachment)
                <a class="text-in-progress underline" href="{{ route('show.attachment', ['id' => $attachment->id]) }}" target="_blank">{{ $attachment->file_name }}</a>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
    
    {{-- to replace by cron jobs --}}
    <div class="w-full bg-white p-5 rounded-lg shadow">
        <p class="text-sm font-semibold mb-3">Ticket Logs</p>
        @foreach ($ticket->histories->sortByDesc('created_at') as $history)
        @if ($history->description)
        <div class="flex flex-col gap-y-1 border-b p-2">
            <p class="text-sm text-gray-500">{{ $history->created_at->format('F d, Y h:i A') }}</p>
            <p class="text-sm">{{$history->description}}</p>
        </div>
        @endif
        @endforeach
        <div class="flex flex-col gap-y-1 border-b p-2">
            <p class="text-sm text-gray-500">{{ $ticket->created_at->format('F d, Y h:i A') }}</p>
            @if ($ticket->customer_id)
            <p class="text-sm">Ticket has set its status to New by {{$ticket->customer->first_name}} {{$ticket->customer->last_name}}.</p>
            @elseif ($ticket->user_id)
            <p class="text-sm">Ticket has set its status to New by  {{$ticket->user->first_name}} {{$ticket->user->last_name}}.</p>
            @endif
        </div>
        <div class="flex flex-col gap-y-1 border-b p-2">
            <p class="text-sm text-gray-500">{{ $ticket->created_at->format('F d, Y h:i A') }}</p>
            @if ($ticket->customer_id)
            <p class="text-sm">Ticket has been assigned to {{ $ticket->employee->first_name }} {{ $ticket->employee->last_name }} by {{$ticket->customer->first_name}} {{$ticket->customer->last_name}} .</p>
            @elseif ($ticket->user_id)
            <p class="text-sm">Ticket has been assigned to {{ $ticket->employee->first_name }} {{ $ticket->employee->last_name }} by {{$ticket->user->first_name}} {{$ticket->user->last_name}}.</p>
            @endif
        </div>
        <div class="flex flex-col gap-y-1 border-b p-2">
            <p class="text-sm text-gray-500">{{ $ticket->created_at->format('F d, Y h:i A') }}</p>
            @if ($ticket->customer_id)
            <p class="text-sm">Ticket has been created by {{$ticket->customer->first_name}} {{$ticket->customer->last_name}} .</p>
            @elseif ($ticket->user_id)
            <p class="text-sm">Ticket has been created by {{$ticket->user->first_name}} {{$ticket->user->last_name}} .</p>
            @endif
        </div>
    </div>
    </div>
    
<script>
    document.addEventListener("DOMContentLoaded", function() {
      
    const photo = document.getElementById('photo');
      const fileName = document.getElementById('file-name');

      photo.addEventListener('change', function() {
        const file = this.files[0];

        if (file) {
            fileName.textContent = file.name
        }
        else {
            fileName.textContent = 'Add attachment';
        }
    });

  });
    $(document).ready(function() {
    $('#department').change(function() {
        var department = $(this).val();
        $.ajax({
            url: '{{ route("get.users") }}', 
            type: 'GET',
            data: { department: department },
            success: function(data) {
                $('#employee').empty();
                $('#employee').append('<option value="">Select the employee</option>');
                $.each(data, function(index, user) {
                  $('#employee').append('<option value="' + user.id + '">' + user.first_name + ' ' + user.last_name + '</option>');
                });

            },
            error: function(xhr, status, error) {
                console.error('Error fetching users:', error);
            }
        });
    });
});
</script>
@include('partials.footer')