@include('partials.header', ['title' => 'adish HAP | File Ticket'])
@include('partials.menu')
<div class="flex flex-row gap-x-10 pt-24">
    <div class="flex-none">
      @include('partials.sidebar')
    </div>
    <div class="sm:ml-64 w-full flex flex-row gap-x-5 bg-custom-gray p-5">
      <div class="w-full bg-white p-5 rounded-lg shadow">
          <p class="text-sm font-semibold">File a Ticket</p>
          <form action="{{ route('tickets.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
          <div class="grid grid-cols-2 gap-x-24 px-2 py-3">
            <div class="flex flex-col">
              @auth('user')
              <label for="name" class="text-sm font-medium">Name</label>
              <input type="text" name="name" id="name" class="mt-2 mb-7 w-full bg-[#EAEAEA] p-2 text-sm rounded-sm" value="{{$user->first_name}} {{$user->last_name}} " readonly>
              @endauth
            </div>
            <div class="flex flex-col">
              <label for="date" class="text-sm font-medium">Date Filed</label>
              <input type="text" name="date" id="date" class="mt-2 mb-7 w-full bg-[#EAEAEA] p-2 text-sm rounded-sm" value="{{ \Carbon\Carbon::now()->format('F d, Y') }}" readonly>
            </div>
            <div class="flex flex-col">
              <label for="department" class="text-sm font-medium">Assign to Department</label>
              <select name="department_id" id="department" class="mt-2 mb-7 w-full border-[1px] border-black p-2 text-sm rounded-sm" required>
                  <option value="" {{ old('department') == "" ? 'selected' : '' }}>Select the department</option>
                  <option value="1" {{ old('department') == "1" ? 'selected' : '' }}>HRAD</option>
                  <option value="2" {{ old('department') == "2" ? 'selected' : '' }}>Team Banana</option>
              </select>
              @error('department')
              <p class="text-xs text-red-700 mt-2">{{$message}}</p>
              @enderror
            </div>
            <div class="flex flex-col">
              <label for="employee" class="text-sm font-medium">Assign to Employee</label>
              <select name="employee_id" id="employee" class="mt-2 mb-7 w-full border-[1px] border-black p-2 text-sm rounded-sm" required>
                  <option value="" {{ old('employee') == "" ? 'selected' : '' }}>Select the employee</option>
              </select>
              @error('employee')
              <p class="text-xs text-red-700 mt-2">{{$message}}</p>
              @enderror
            </div>
            <div class="flex flex-col">
              <label for="title" class="text-sm font-medium">Title</label>
              <input type="text" name="title" id="title" class="mt-2 mb-7 w-full border-[1px] border-black p-2 text-sm rounded-sm" placeholder="Describe the subject of the ticket" required value="{{old('title')}}">
              @error('title')
              <p class="text-xs text-red-700 mt-2">{{$message}}</p>
              @enderror
            </div>
            <div class="flex flex-col">
              <label for="priority" class="text-sm font-medium">Priority Level</label>
              <input type="text" name="priority" id="priority" class="mt-2 mb-7 w-full bg-[#EAEAEA] p-2 text-sm rounded-sm" value="Required" readonly>
            </div>
          </div>
          <div class="flex flex-col px-2 mb-7 h-64">
            <label for="description" class="text-sm font-medium mb-2">Description</label>
            <div id="editor" class="overflow-y-auto"></div>
            <textarea name="description" id="description" style="display: none;"></textarea>
            @error('description')
            <p class="text-xs text-red-700 mt-2">{{$message}}</p>
            @enderror
          </div>
          <div class="flex flex-col px-2">
              <label for="attachments" class="text-sm font-medium">Attachments</label>
              <label for="attachments" class="flex flex-col items-center justify-center w-full h-30 border-2 border-gray-300 border-dashed rounded-sm cursor-pointer mt-2">
                  <div class="flex flex-col items-center justify-center pt-5 pb-6">
                      <svg class="w-6 h-6 mt-1 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                      </svg>
                      <p class="mb-2 text-sm font-medium text-gray-500">Click to upload</p>
                      <p class="text-xs text-gray-500">Accepts the following formats with size limits of 50MB:</p>
                      <p class="text-xs text-gray-500">JPEG, PNG, GIF; and MP4 and MOV;</p>
                  </div>
                  <input id="attachments" name="attachments[]" type="file" class="hidden" multiple accept=".jpg, .jpeg, .png, .gif, .mp4, .mov" />
              </label>
                <ul id="file-list" class="text-sm mt-3">No file chosen</ul>
                @error('attachments')
                  <p class="text-xs text-red-700 mt-2">{{$message}}</p> 
                @enderror
                @error('attachments.*')
                <p class="text-xs text-red-700 mt-2">{{$message}}</p>
                @enderror
            </div> 
            <div class="flex flex row gap-x-2 justify-end mr-2">
              <button id="cancelButton" class="w-24 p-2 mt-5 border border-custom-orange rounded-sm text-sm font-semibold hover:bg-orange-500 hover:text-white">Cancel</button>
              <button type="submit" class="w-24 p-2 mt-5 bg-custom-orange rounded-sm text-white text-sm font-semibold hover:bg-orange-500">File</button>

              {{-- <button disabled type="button" class="text-white bg-custom-orange font-medium rounded-sm text-sm w-32 p-2 mt-5 text-center inline-flex items-center">
                <svg aria-hidden="true" role="status" class="inline w-4 h-4 me-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                </svg>
                Processing...
                </button> --}}
          </div>
        </form>
    </div>
  </div>
    {{-- quill text editor scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
    <script>
      const quill = new Quill('#editor', {
        theme: 'snow',
        modules: {
        toolbar: [
            ['bold', 'italic', 'underline'],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            ['clean']
        ]
      },
        placeholder: 'Describe the problem that you have encountered',
      });

      quill.on('text-change', function() {
        var html = quill.root.innerHTML;
        document.getElementById('description').value = html;
    });
    </script>
    
    <script>
      var cancelButton = document.getElementById("cancelButton");
      const fileInput = document.getElementById('attachments');
      const fileList = document.getElementById('file-list');
      cancelButton.addEventListener("click", function(){
      var clearElements = ["department", "employee", "title", "description", "attachments"];
          clearElements.forEach(function(elementId) {
          document.getElementById(elementId).value = "";
          quill.setContents([]);
          fileInput.value = '';  
          fileList.textContent = 'No file chosen';
      });
      });

      document.addEventListener("DOMContentLoaded", function() {
      const input = document.getElementById('attachments');
      const fileList = document.getElementById('file-list');

      input.addEventListener('change', function() {
        fileList.innerHTML = '';

        if (input.files.length > 0) {
            Array.from(input.files).forEach(file => {
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