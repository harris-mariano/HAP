@include('partials.header', ['title' => 'adish HAP | Individual Departments'])
@include('partials.menu')
<div class="flex flex-row gap-x-10 pt-24">
    <div class="flex-none">
      @include('partials.sidebar')
    </div>
    <div class="sm:ml-64 w-full min-h-screen flex flex-col bg-custom-gray p-5 gap-5">
        @include('components.messages')
        
        <div class="w-full bg-white p-5 rounded-lg shadow">
        <form action="{{ route('companies.update', ['company' => $department->company_id]) }}" method="POST">
            @method('PUT')
            @csrf
            <div class="p-5 flex flex-col gap-y-3">
                <p class="text-sm font-semibold">Edit Company Name</p>
                <div>
                    <label for="company" class="text-sm font-medium">Company:</label>
                    <input type="text" name="company" id="company" class="mt-2 mb-5 w-full border-[1px] border-black p-2 text-sm rounded-sm" required value="{{$department->company->name}}">
                    @error('company')
                    <p class="text-xs text-red-700 mt-2">{{$message}}</p>
                    @enderror
                  </div>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="w-32 p-2 mt-5 bg-custom-orange rounded-sm text-white text-sm font-semibold">Update Company</button>
            </div>
        </form>
        </div>

        <div class="w-full bg-white p-5 rounded-lg shadow">
            <form action="{{ route('departments.update', ['department' => $department->id]) }}" method="POST">
                @method('PUT')
                @csrf
                <div class="p-5 flex flex-col gap-y-3">
                    <p class="text-sm font-semibold">Edit Department Name</p>
                    <div class="flex flex-col mb-5">
                        <label for="department" class="text-sm font-medium">Department:</label>
                        <input type="text" name="department" id="department" class="mt-2 mb-5 w-full border-[1px] border-black p-2 text-sm rounded-sm" required value="{{$department->name}}">
                        @error('department')
                        <p class="text-xs text-red-700 mt-2">{{$message}}</p>
                        @enderror
                      </div>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="w-35 p-2 mt-5 bg-custom-orange rounded-sm text-white text-sm font-semibold">Update Department</button>
                </div>
            </form>
            </div>
    </div>
    {{-- <script>
    document.addEventListener("DOMContentLoaded", function() {
    $(document).ready(function() {
    $('#company').change(function() {
        var company = $(this).val();
        console.log("company", company); 
        $.ajax({
            url: '{{ route("get.departments") }}', 
            type: 'GET',
            data: { company: company },
            success: function(data) {
                console.log('data', data);
                $('#department').empty();
                $('#department').append('<option value="">Select the department</option>');
                $.each(data, function(index, department) {
                  $('#department').append('<option value="' + department.id + '">' + department.name + '</option>');
                });
            },
            error: function(xhr, status, error) {
                console.error('Error fetching users:', error);
            }
        });
    });
});
});
    </script> --}}
@include('partials.footer')