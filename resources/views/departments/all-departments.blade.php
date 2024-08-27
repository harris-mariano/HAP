@include('partials.header', ['title' => 'adish HAP | All Users'])
@include('partials.menu')
<div class="flex flex-row gap-x-10 pt-20">
    <div class="flex-none">
      @include('partials.sidebar')
    </div>
    <div class="sm:ml-64 w-full min-h-screen flex flex-col gap-x-5 bg-custom-gray p-5">
        @include('components.messages')
        <div class="flex flex-col gap-y-5">
    <div class="w-full bg-white p-5 rounded-lg shadow">
        <div class="flex flex-row items-center">
            <p class="text-sm font-semibold">All Departments and Companies</p>
            <a href="{{ route('departments.create') }}" class="p-2 rounded-sm ml-auto text-sm font-semibold text-custom-orange mr-1 hover:bg-custom-orange hover:text-white">Create New
            </a> 
        </div>
        <div class="relative flex items-center mt-5">
            <input type="text" id="searchDepartment" placeholder="Type a department or company name here" class="bg-gray-100 p-2 pr-10 text-sm rounded-sm w-full">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="absolute right-3 h-5 w-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
            </svg>
        </div>
        <div class="relative overflow-x-auto mt-5">
            <table id="departmentsTable" class="w-full text-sm text-left rtl:text-right">
                <thead class="text-xs text-gray-700 uppercase border-b border-t">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Department
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Company
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($allDepartments as $department)
                    <tr class="border-b">
                        <td class="px-6 py-4">{{$department->name}}</td>
                        <td class="px-6 py-4">{{$department->company->name}}</td>
                        <td class="px-6 py-4">
                            <a href="{{ route('departments.show', ['department' => $department->id]) }}" class="p-2 font-medium text-in-progress rounded-sm hover:bg-in-progress hover:text-white">View</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-5">
                {{ $allDepartments->links() }}
            </div>
        </div>
    </div>
    
    </div>

   <script>
    document.addEventListener("DOMContentLoaded", function() {

        function sanitizeInput(event) {
              event.target.value = event.target.value.replace(/[^A-Za-z\s-]/g, '');
          }
      
          const inputs = [
              document.getElementById('first_name'),
              document.getElementById('middle_name'),
              document.getElementById('last_name'),
              document.getElementById('position')
          ];
      
          inputs.forEach(input => {
              input.addEventListener('input', sanitizeInput);
          });

          const fileInput = document.getElementById('profile_picture');
        const imagePreview = document.getElementById('profile_picture_preview');

        fileInput.addEventListener('change', function(event) {
            const file = event.target.files[0]; 
            
            if (file) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                };
                
                reader.readAsDataURL(file); 
            } else {
                imagePreview.src = '{{ asset('images/user.png') }}';
            }
        });
        
    var cancelButton = document.getElementById("cancelButton");
    const superuserCheckbox = document.getElementById('superuser');
    cancelButton.addEventListener("click", function(){
    var clearElements = ["profile_picture", "email", "first_name", "middle_name", "last_name", "department", "position", "company", "superuser"];
        clearElements.forEach(function(elementId) {
        document.getElementById(elementId).value = "";
        superuserCheckbox.checked = false;
        imagePreview.src = '{{ asset('images/user.png') }}';
    });
    });

    const togglePassword = document.getElementById('togglePassword');
    const passwordField = document.getElementById('password');

    togglePassword.addEventListener('click', function() {
      const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
      passwordField.setAttribute('type', type);
      this.classList.toggle('fa-eye');
      this.classList.toggle('fa-eye-slash');
    });

    const searchUser = document.getElementById('searchUser');
    const usersTable = document.getElementById('usersTable').getElementsByTagName('tbody')[0];

    searchUser.addEventListener('input', function () {
        const searchQuery = this.value.trim().toLowerCase();

        Array.from(usersTable.rows).forEach(function (row) {
            const title = row.cells[1].textContent.trim().toLowerCase();
            if (title.includes(searchQuery)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
          });
      });

    const searchDepartment = document.getElementById('searchDepartment');
    const departmentsTable = document.getElementById('departmentsTable').getElementsByTagName('tbody')[0];

    searchDepartment.addEventListener('input', function () {
        const searchQuery = this.value.trim().toLowerCase();

        Array.from(departmentsTable.rows).forEach(function (row) {
            const department = row.cells[0].textContent.trim().toLowerCase();
            const company = row.cells[1].textContent.trim().toLowerCase();
            if (department.includes(searchQuery) || company.includes(searchQuery)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
          });
      });

    $(document).ready(function() {
    $('#company_id').change(function() {
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
</script>
@include('partials.footer')