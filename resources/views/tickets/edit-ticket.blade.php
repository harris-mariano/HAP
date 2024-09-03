@include('partials.header', ['title' => 'adish HAP | Individual Ticket'])
@include('partials.menu')
<div class="flex flex-row gap-x-10 pt-20">
    <div class="flex-none">
      @include('partials.sidebar')
    </div>
    <div class="sm:ml-64 w-full flex flex-col gap-y-5 bg-custom-gray p-5">
        @include('components.messages')
        <div class="w-full bg-white p-5 rounded-lg shadow">
            <form action="{{ route('tickets.update', ['ticket' => $ticket->id]) }}" method="POST">
              @auth('user')
              @method('PUT')
              @csrf
            <div class="grid grid-cols-2 gap-x-24 px-2 py-3">
                <div class="flex flex-col">
                    <label for="status" class="text-sm font-medium">Ticket Status</label>
                    @if(auth('user')->user()->department_id == $ticket->department_id || auth('user')->user()->isSuperUser())
                    <select name="status_id" id="status" class="mt-2 mb-7 w-full border-[1px] border-black p-2 text-sm rounded-sm" required>
                        <option value="" {{ $ticket->status_id == "" ? 'selected' : '' }}>Select department</option>
                        @foreach($statuses as $status)
                        <option value="{{$status->id}}" {{ $ticket->status_id == $status->id ? 'selected' : ''}}>{{$status->category}}</option>
                      @endforeach
                        </select>
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
                </div>
                <div class="flex flex-col">
                    <label for="date" class="text-sm font-medium">Last Updated on</label>
                    <div id="date" class="mt-2 mb-7 w-full bg-[#EAEAEA] p-2 text-sm rounded-sm">{{ $ticket->updated_at->format('F d, Y h:i A') }}</div>
                </div>
                <div class="flex flex-col">
                    <label for="department" class="text-sm font-medium">Department Assigned</label>
                    @if(auth('user')->user()->isCustomer())
                    <div id="department" class="mt-2 mb-7 w-full bg-[#EAEAEA] p-2 text-sm rounded-sm">{{ $ticket->department->name }}</div>
                    @elseif(auth('user')->user()->department_id == $ticket->department_id || auth('user')->user()->isSuperUser())
                        <select name="department_id" id="department" class="mt-2 mb-7 w-full border-[1px] border-black p-2 text-sm rounded-sm" required>
                            <option value="" {{ $ticket->department_id == "" ? 'selected' : '' }}>Select department</option>
                            @foreach($departments as $department)
                            <option value="{{$department->id}}" {{ $ticket->department_id == $department->id ? 'selected' : ''}}>{{$department->name}}</option>
                          @endforeach
                        </select>
                    @else
                    <div id="department" class="mt-2 mb-7 w-full bg-[#EAEAEA] p-2 text-sm rounded-sm">{{ $ticket->department->name }}</div>
                    @endif
                </div>
                <div class="flex flex-col">
                    <label for="employee" class="text-sm font-medium">Employee Assigned</label>
                    @if(auth('user')->user()->isCustomer())
                    <div id="employee" class="mt-2 mb-7 w-full bg-[#EAEAEA] p-2 text-sm rounded-sm">{{ $ticket->employee->first_name }} {{ $ticket->employee->last_name }}</div>
                    @elseif(auth('user')->user()->department_id == $ticket->department_id || auth('user')->user()->isSuperUser())
                        <select name="employee_id" id="employee" class="mt-2 mb-7 w-full border-[1px] border-black p-2 text-sm rounded-sm" required>
                            <option value="" {{$ticket->employee->id == "" ? 'selected' : ''}}>Select employee</option>
                            @foreach($employees as $employee)
                            <option value="{{$employee->id}}" {{$ticket->employee->id == $employee->id ? 'selected' : ''}}>{{$employee->first_name}} {{$employee->last_name}}</option>
                            @endforeach
                        </select>
                    @else
                    <div id="employee" class="mt-2 mb-7 w-full bg-[#EAEAEA] p-2 text-sm rounded-sm">{{ $ticket->employee->first_name }} {{ $ticket->employee->last_name }}</div>
                    @endif
                </div>
                <div class="flex flex-col">
                    <label for="title" class="text-sm font-medium">Title</label>
                    <div id="title" class="mt-2 mb-5 w-full bg-[#EAEAEA] p-2 text-sm rounded-sm">{{ $ticket->title }}</div>
                </div>
                <div class="flex flex-col">
                    <label for="priority" class="text-sm font-medium">Priority Level</label>
                    @if(auth('user')->user()->isCustomer())
                    <div id="priority" class="mt-2 mb-5 w-full bg-[#EAEAEA] p-2 text-sm rounded-sm">{{ $ticket->priority->category }}</div>
                    @elseif(auth('user')->user()->department_id == $ticket->department_id || auth('user')->user()->isSuperUser())
                    <select name="priority_id" id="priority" class="mt-2 mb-7 w-full border-[1px] border-black p-2 text-sm rounded-sm" required>
                        <option value="" {{ $ticket->priority_id == "" ? 'selected' : '' }}>Select priority</option>
                        @foreach($priorities as $priority)
                            <option value="{{ $priority->id }}" {{ $ticket->priority_id == $priority->id ? 'selected' : '' }}>{{ $priority->category }}</option>
                        @endforeach
                    </select>
                    @else
                    <div id="priority" class="mt-2 mb-5 w-full bg-[#EAEAEA] p-2 text-sm rounded-sm">{{ $ticket->priority->category }}</div>
                    @endif
                </div>
      </div> 
      <div class="flex flex-col px-2 h-auto mb-7">
        <label for="description" class="text-sm font-medium mb-2">Description</label>
        <div class="ql-editor mt-1 w-full h-auto bg-[#EAEAEA] p-2 text-sm rounded-sm">{!! $ticket->description !!}</div>
      </div>
      <div class="flex flex-col px-2 mb-7">
        <label for="attachments" class="text-sm font-medium mb-2">Attachments</label>
        @if (count($ticket->attachments) > 0 )
        <div class="grid grid-cols-2 gap-x-24 py-3">
            @foreach ($ticket->attachments as $attachment)
            <div class="flex flex-row gap-x-2 px-2 pb-3" >
                    @if (Str::endsWith($attachment->file_name, ['.jpg', '.jpeg', '.png', '.bmp']))
                    <img src="{{ asset($attachment->file_path) }}" alt="{{ $attachment->file_name }}" class="w-32 h-20 rounded-sm">
                    @elseif(Str::endsWith($attachment->file_name, ['.mov', '.mp4']))
                    <div class="border rounded-sm w-32 h-20 items-center flex justify-center">
                        <video controls class="w-32 h-20 rounded-sm">
                            <source src="{{ asset($attachment->file_path) }}" type="video/mp4">
                        </video>
                    </div>
                    @else
                    <div class="border rounded-sm w-32 h-20 items-center flex justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 text-custom-orange">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                      </svg>
                    </div>
                    @endif
                    <div class="flex flex-col">
                        <a href="{{ route('show.attachment', ['id' => $attachment->id]) }}" target="_blank" class="text-sm font-medium underline text-in-progress">{{ $attachment->file_name }}</a>
                    <p class="text-xs">Uploaded on {{ $attachment->created_at->format('F d, Y h:i A') }}</p>
                    </div>
            </div>
            @endforeach
            </div>
            @else 
            <label for="attachments" class="flex flex-col items-center justify-center w-full h-30 border border-gray-300 rounded-sm cursor-pointer mt-2">
                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 ">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                    </svg>
                    <p class="mt-1 text-sm font-medium">No attached files</p>
                </div>
            </label>
            @endif
        @if(auth('user')->user()->department_id == $ticket->department_id || auth('user')->user()->isSuperUser())
        <div class="flex justify-end">
            <button type="submit" class="w-24 p-2 mt-5 bg-custom-orange rounded-sm text-white text-sm font-semibold hover:bg-orange-500">Update</button>
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
            <textarea name="comment" id="comment" rows="5" class="border w-full text-sm px-2.5 py-2 rounded-sm" placeholder="Write a comment..." required>{{old('comment')}}</textarea>
            <label for="photo" class="flex flex-col ml-3 -mt-9 cursor-pointer">
                <div class="flex flex-row items-center gap-x-2 ">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 text-in-progress">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                      </svg>                      
                    <p id="file-name" class="text-sm text-in-progress">Attach a photo or video</p>
                </div>
                <input id="photo" name="photo" type="file" class="hidden" accept=".jpg, .jpeg, .png, .bmp, .mov, .mp4"/>
            </label>
            @error('comment')
            <p class="text-xs text-red-700 my-4">{{$message}}</p>
            @enderror
            @error('photo')
            <p class="text-xs text-red-700 my-4">{{$message}}</p>
            @enderror
            <div class="flex justify-end">
                <button type="submit" class="w-24 p-2 mt-5 bg-custom-orange rounded-sm text-white text-sm font-semibold hover:bg-orange-500">Post</button>
            </div>
         </form>
        </div>
        @foreach($ticket->comments as $comment)
        <div class="border-b p-2 ">
            <div class="flex flex-row items-center justify-between">
                <div class="flex flex-row items-center gap-x-2">
                    @if ($comment->user && isset($comment->user->profile_picture))
                        <img src="{{ asset('storage/' . $comment->user->profile_picture) }}" class="w-8 h-8 mb-3 mt-2 rounded-full object-cover" alt="Profile Picture" />
                    @else
                        <img src="{{ asset('images/user.png') }}" class="w-8 h-8" alt="Default Profile Picture" />
                    @endif
                    <p class="text-sm font-medium">
                    {{ $comment->user->first_name }} {{ $comment->user->last_name }}
                    </p>
                </div>
                <p class="text-xs text-gray-500">{{ $comment->updated_at->format('F d, Y h:i A') }}</p>
            </div>
            <div class="flex flex-col px-10 gap-y-2 text-sm">
                <p>{{$comment->comment}}</p>
                @foreach ($comment->attachments as $attachment)
                @if (Str::endsWith($attachment->file_name, ['.jpg', '.jpeg', '.png', '.bmp']))
                <img src="{{ asset($attachment->file_path) }}" alt="{{ $attachment->file_name }}" class="w-48 h-32 rounded-sm">
                @else
                <video controls class="w-48 h-32 rounded-sm">
                    <source src="{{ asset($attachment->file_path) }}" type="video/mp4">
                </video>
                @endif
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
            <p class="text-xs text-gray-500">{{ $history->created_at->format('F d, Y h:i A') }}</p>
            <p class="text-sm">{{$history->description}}</p>
        </div>
        @endif
        @endforeach
        @if ($ticket->is_admin_creation == true ) 
        <div class="flex flex-col gap-y-1 border-b p-2">
            <p class="text-xs text-gray-500">{{ $ticket->created_at->format('F d, Y h:i A') }}</p>
            <p class="text-sm">Ticket has set its priority to {{$ticket->priority->category}} by {{$ticket->admin->first_name}} {{$ticket->admin->last_name}}.</p>
        </div>
        @else
        <div class="flex flex-col gap-y-1 border-b p-2">
            <p class="text-xs text-gray-500">{{ $ticket->created_at->format('F d, Y h:i A') }}</p>
            <p class="text-sm">Ticket has set its priority to {{$ticket->priority->category}} by {{$ticket->user->first_name}} {{$ticket->user->last_name}}.</p>
        </div>
        @endif
        <div class="flex flex-col gap-y-1 border-b p-2">
            <p class="text-xs text-gray-500">{{ $ticket->created_at->format('F d, Y h:i A') }}</p>
            @if ($ticket->is_admin_creation == true) 
            <p class="text-sm">Ticket has set its status to New by {{$ticket->admin->first_name}} {{$ticket->admin->last_name}}.</p>
            @else
            <p class="text-sm">Ticket has set its status to New by {{$ticket->user->first_name}} {{$ticket->user->last_name}}.</p>
            @endif
        </div>
        <div class="flex flex-col gap-y-1 border-b p-2">
            <p class="text-xs text-gray-500">{{ $ticket->created_at->format('F d, Y h:i A') }}</p>
            @if ($ticket->is_admin_creation == true) 
            <p class="text-sm">Ticket has been assigned to {{ $ticket->employee->first_name }} {{ $ticket->employee->last_name }} by {{$ticket->admin->first_name}} {{$ticket->admin->last_name}}.</p>
            @else
            <p class="text-sm">Ticket has been assigned to {{ $ticket->employee->first_name }} {{ $ticket->employee->last_name }} by {{$ticket->user->first_name}} {{$ticket->user->last_name}}.</p>
            @endif
        </div>
        <div class="flex flex-col gap-y-1 border-b p-2">
            <p class="text-xs text-gray-500">{{ $ticket->created_at->format('F d, Y h:i A') }}</p>
            @if ($ticket->is_admin_creation == true) 
            <p class="text-sm">Ticket has been created by {{$ticket->admin->first_name}} {{$ticket->admin->last_name}} for {{$ticket->user->first_name}} {{$ticket->user->last_name}}.</p>
            @else
            <p class="text-sm">Ticket has been created by {{$ticket->user->first_name}} {{$ticket->user->last_name}} .</p>
            @endif
        </div>
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
                $('#employee').append('<option value="">Select employee</option>');
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