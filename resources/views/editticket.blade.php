@include('partials.header', ['title' => 'adish HAP | Individual Ticket'])
@include('partials.menu')
<div class="flex flex-row gap-x-10">
    <div class="flex-none">
      @include('partials.sidebar')
    </div>
    <div class="sm:ml-64 w-full flex flex-col gap-y-5 bg-custom-gray p-5">
        <div class="w-full bg-white p-5 rounded-lg shadow">
            <form action="{{ route('tickets.update', ['ticket' => $ticket->id]) }}" method="POST" enctype="multipart/form-data">
              @method('PUT')
              @csrf
            <div class="grid grid-cols-2 gap-x-24 px-2 py-3">
                <div class="flex flex-col">
                    <label for="status" class="text-sm font-medium">Ticket Status:</label>
                    @foreach ($ticket->histories as $history)
                    @if ($history->status->category == 'New')
                        <div id="status" class="bg-open mt-2 text-white mb-7 w-full bg-[#EAEAEA] p-2 text-sm rounded-sm">{{ $history->status->category }}</div>
                    @elseif ($history->status->category == 'In Progress')
                        <div id="status" class="bg-in-progress mt-2 text-white mb-7 w-full bg-[#EAEAEA] p-2 text-sm rounded-sm">{{ $history->status->category }}</div>
                    @elseif ($history->status->category == 'Resolved')
                        <div id="status" class="bg-resolved mt-2 text-white mb-7 w-full bg-[#EAEAEA] p-2 text-sm rounded-sm">{{ $history->status->category }}</div>
                    @elseif ($history->status->category == 'Closed')
                        <div id="status" class="bg-closed mt-2 text-white mb-7 w-full bg-[#EAEAEA] p-2 text-sm rounded-sm">{{ $history->status->category }}</div>
                    @else
                        {{ $history->status->category }}
                    @endif
                    @endforeach
                </div>
                <div class="flex flex-col">
                    <label for="date" class="text-sm font-medium">Last Updated on:</label>
                    <div id="date" class="mt-2 mb-7 w-full bg-[#EAEAEA] p-2 text-sm rounded-sm">{{ $ticket->updated_at->format('F d, Y') }}</div>
                </div>
                <div class="flex flex-col">
                    <label for="department" class="text-sm font-medium">Department Assigned:</label>
                    @foreach ($ticket->histories as $history)
                    @if ($history->status->id == '3' || $history->status->id == '4')
                        <div id="department" class="mt-2 mb-7 w-full bg-[#EAEAEA] p-2 text-sm rounded-sm">{{ $ticket->department->name }}</div>
                    @else
                        <select name="department_id" id="department" class="mt-2 mb-7 w-full border-[1px] border-black p-2 text-sm rounded-sm" required>
                            <option value="" {{ $ticket->department->id == "" ? 'selected' : '' }}>Select the department</option>
                            <option value="1" {{ $ticket->department->id == "1" ? 'selected' : '' }}>HRAD</option>
                            <option value="2" {{ $ticket->department->id == "2" ? 'selected' : '' }}>Team Banana</option>
                        </select>
                        @error('department')
                        <p class="text-xs text-red-700 mt-2">{{$message}}</p>
                        @enderror
                    @endif
                    @endforeach
                </div>
                <div class="flex flex-col">
                    <label for="employee" class="text-sm font-medium">Employee Assigned:</label>
                    @foreach ($ticket->histories as $history)
                    @if ($history->status->id == '3' || $history->status->id == '4')
                        <div id="employee" class="mt-2 mb-7 w-full bg-[#EAEAEA] p-2 text-sm rounded-sm">{{ $ticket->employee->first_name }} {{ $ticket->employee->last_name }}</div>
                    @else
                        <select name="employee_id" id="employee" class="mt-2 mb-7 w-full border-[1px] border-black p-2 text-sm rounded-sm" required>
                            <option value="" {{$ticket->employee->id == "" ? 'selected' : ''}}>Select the employee</option>
                            @foreach($employees as $employee)
                            <option value="{{$employee->id}}" {{$ticket->employee->id == $employee->id ? 'selected' : ''}}>{{$employee->first_name}} {{$employee->last_name}}</option>
                            @endforeach
                        </select>
                        @error('employee')
                        <p class="text-xs text-red-700 mt-2">{{$message}}</p>
                        @enderror
                    @endif
                    @endforeach
                </div>
                <div class="flex flex-col">
                    <label for="title" class="text-sm font-medium">Title:</label>
                    @foreach ($ticket->histories as $history)
                    @if ($history->status->id == '3' || $history->status->id == '4')
                        <div id="title" class="mt-2 mb-7 w-full bg-[#EAEAEA] p-2 text-sm rounded-sm">{{ $ticket->title }}</div>
                    @else
                    <input type="text" name="title" id="title" class="mt-2 mb-7 w-full border-[1px] border-black p-2 text-sm rounded-sm" placeholder="Describe the subject of the ticket" required value="{{ $ticket->title }}">
                    @error('title')
                    <p class="text-xs text-red-700 mt-2">{{$message}}</p>
                    @enderror
                    @endif
                    @endforeach
                </div>
                <div class="flex flex-col">
                    <label for="priority" class="text-sm font-medium">Priority Level:</label>
                    <div id="priority" class="mt-2 mb-7 w-full bg-[#EAEAEA] p-2 text-sm rounded-sm">{{ $ticket->priority->category }}</div>
                </div>
      </div> 
      <div class="flex flex-col px-2 mb-7 h-64">
        <label for="description" class="text-sm font-medium mb-2">Description:</label>
        @foreach ($ticket->histories as $history)
        @if ($history->status->id == '3' || $history->status->id == '4')
        <div class="mt-1 mb-7 w-full h-64 bg-[#EAEAEA] p-2 text-sm rounded-sm">{!! $ticket->description !!}</div>
        @else
        <div id="editor" class="overflow-y-auto">{!! $ticket->description !!}</div>
        <textarea name="description" id="description" style="display: none;"></textarea>
        @endif
        @endforeach
      </div>
      <div class="flex flex-col px-2 mb-7">
        <label for="attachments" class="text-sm font-medium mb-2">Attachments:</label>
        @foreach ($ticket->histories as $history)
        @if ($history->status->id == '3' || $history->status->id == '4')
        <div class="flex flex-col space-y-2">
            @if (count($ticket->attachments) > 0 )
            @foreach ($ticket->attachments as $attachment)
                <a href="{{ route('show.attachment', ['id' => $attachment->id]) }}" target="_blank" class="underline text-in-progress text-sm">{{ $attachment->file_name }}</a>
            @endforeach
            @else 
            <label for="attachments" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 rounded-lg cursor-pointer mt-2">
                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-10">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                      </svg>
                    <p class="mb-2 mt-2 text-sm font-medium">No attached files</p>
                </div>
            </label>
            @endif
        </div>
        @else 
        <label for="attachments" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer mt-2">
            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                <svg class="w-8 h-8 mb-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                </svg>
                <p class="mb-2 text-sm font-medium text-gray-500">Click to upload</p>
                <p class="text-xs text-gray-500">Accepts the following formats with size limits of 50MB:</p>
                <p class="text-xs text-gray-500">JPEG, PNG, GIF; MP4 and MOV; and PDF, DOCX.</p>
            </div>
            <input id="attachments" name="attachments[]" type="file" class="hidden" multiple accept=".jpg, .jpeg, .png, .gif, .mp4, .mov, .pdf, .docx" />
        </label>
        <ul id="file-list" class="text-sm mt-3">No file chosen</ul>
        @foreach ($ticket->attachments as $attachment)
                <a href="{{ route('show.attachment', ['id' => $attachment->id]) }}" target="_blank" class="mt-1 underline text-in-progress text-sm">{{ $attachment->file_name }}</a>
        @endforeach
        @endif
        @endforeach
        @if (!($history->status->id == '3' || $history->status->id == '4'))
        <div class="flex justify-end">
            <button type="submit" class="w-32 p-2 mt-5 bg-custom-orange rounded-sm text-white text-sm font-bold">Update Ticket</button>
        </div>
        @endif
    </form>
    </div>
    </div>

    <div class="w-full bg-white p-5 rounded-lg shadow">
        <p class="text-sm font-semibold">Discussions ({{$ticket->comments->count()}})</p>
        @if ($history->status->id == '3' || $history->status->id == '4')
        @foreach($ticket->comments as $comment)
        <div class="border-b p-3 mt-5">
            <div class="flex flex-row items-center justify-between">
                <div class="flex flex-row items-center gap-x-2">
                    <img src="{{ asset('images/user.png') }}" class="w-8 h-8" alt="Default Profile Picture" />
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
            <p class="text-sm py-3 px-10">{{$comment->comment}}</p>
        </div>
        @endforeach
        @else
        <div class="mt-2">
            <form action="{{route('comment.create', ['id' => $ticket->id])}}" method="POST" enctype="multipart/form-data">
            @csrf
            <textarea name="comment" id="comment" rows="5" class="border w-full text-sm px-4 py-2" placeholder="Write comment..." required></textarea>
            <label for="photo" class="flex flex-col ml-3 -mt-9 cursor-pointer">
                <div class="flex flex-row items-center gap-x-2 ">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 text-in-progress">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                      </svg>                      
                    <p id="file-name" class="text-sm text-in-progress">Add a photo</p>
                </div>
                <input id="photo" name="photo" type="file" class="hidden" accept=".jpg, .jpeg, .png" />
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
        @endif
    </div>

    <div class="w-full bg-white p-5 rounded-lg shadow">
        <p class="text-sm font-semibold mb-3">Ticket Logs</p>
        @if($history->status->id == '2')
        <div class="flex flex-col gap-y-1 border-b p-2">
            <p class="text-sm text-gray-500">{{ $ticket->created_at->format('F d, Y') }}</p>
            <p class="text-sm">Ticket has set its status from "New" to "{{ $history->status->category }}".</p>
        </div>
        @elseif ($history->status->id == '3')
        <div class="flex flex-col gap-y-1 border-b p-2">
            <p class="text-sm text-gray-500">{{ $ticket->created_at->format('F d, Y') }}</p>
            <p class="text-sm">Ticket has set its status from "In Progress" to "{{ $history->status->category }}".</p>
        </div>
        <div class="flex flex-col gap-y-1 border-b p-2">
            <p class="text-sm text-gray-500">{{ $ticket->created_at->format('F d, Y') }}</p>
            <p class="text-sm">Ticket has set its status from "New" to "In Progress".</p>
        </div>
        @elseif ($history->status->id == '4')
        <div class="flex flex-col gap-y-1 border-b p-2">
            <p class="text-sm text-gray-500">{{ $ticket->created_at->format('F d, Y') }}</p>
            <p class="text-sm">Ticket has set its status from "In Progress" to "{{ $history->status->category }}".</p>
        </div>
        <div class="flex flex-col gap-y-1 border-b p-2">
            <p class="text-sm text-gray-500">{{ $ticket->created_at->format('F d, Y') }}</p>
            <p class="text-sm">Ticket has set its status from "New" to "In Progress".</p>
        </div>
        @endif
        <div class="flex flex-col gap-y-1 border-b p-2">
            <p class="text-sm text-gray-500">{{ $ticket->created_at->format('F d, Y') }}</p>
            <p class="text-sm">Ticket has set its status to "New".</p>
        </div>
        <div class="flex flex-col gap-y-1 border-b p-2">
            <p class="text-sm text-gray-500">{{ $ticket->created_at->format('F d, Y') }}</p>
            <p class="text-sm">Ticket has been assigned to {{ $ticket->employee->first_name }} {{ $ticket->employee->last_name }}.</p>
        </div>
        <div class="flex flex-col gap-y-1 border-b p-2">
            <p class="text-sm text-gray-500">{{ $ticket->created_at->format('F d, Y') }}</p>
            @auth('customer')
            <p class="text-sm">Ticket has been created by {{$ticket->customer->first_name}} {{$ticket->customer->last_name}} .</p>
            @elseauth('user')
            <p class="text-sm">Ticket has been created by {{$ticket->user->first_name}} {{$ticket->user->last_name}} .</p>
            @endauth
        </div>
    </div>
      
    </div>
    
{{-- quill text editor scripts --}}
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
<script>
  const quill = new Quill('#editor', {
    theme: 'snow',
    modules: {
    toolbar: [
        [{ 'header': 1 }, { 'header': 2 }],
        ['bold', 'italic', 'underline'],
        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
        ['clean']
    ]
  }});

  quill.on('text-change', function() {
    var html = quill.root.innerHTML;
    document.getElementById('description').value = html;
});
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
      const attachment = document.getElementById('attachments');
      const fileList = document.getElementById('file-list');

      attachment.addEventListener('change', function() {
        fileList.innerHTML = '';

        if (attachment.files.length > 0) {
            Array.from(attachment.files).forEach(file => {
                const listItem = document.createElement('li');
                listItem.textContent = file.name;
                fileList.appendChild(listItem);
            });
            fileList.classList.add('underline');
            fileList.classList.add('text-blue-500');
        } else {
            const listItem = document.createElement('li');
            listItem.textContent = 'No file chosen';
            fileList.appendChild(listItem);
            fileList.classList.remove('underline');
            fileList.classList.remove('text-blue-700');
        }
    });

    const photo = document.getElementById('photo');
      const fileName = document.getElementById('file-name');

      photo.addEventListener('change', function() {
        const file = this.files[0];

        if (file) {
            fileName.textContent = file.name
        }
        else {
            fileName.textContent = 'Add a photo';
        }
    });

    var editor = document.getElementById('editor');
    var description = document.getElementById('description');

    description.value = editor.querySelector('.ql-editor').innerHTML.trim();

    editor.addEventListener('input', function () {
        description.value = editor.querySelector('.ql-editor').innerHTML.trim();
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