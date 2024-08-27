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
            <p class="text-sm font-semibold">Create a New User or Customer</p>
            <div class="flex flex-row flex">
                <div class="w-1/2 p-10 ">
                    <form action="{{route('users.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                            <label for="profile_picture" class="text-sm font-medium">Profile Picture</label>
                            <img id="profile_picture_preview" src="../images/user.png" alt="Default Profile Picture" class="w-20 h-20 mb-3 mt-2 rounded-full object-cover">
                            <input type="file"  name="profile_picture" id="profile_picture" class="w-full text-sm file:mr-2 file:py-2 file:px-3 file:rounded-sm file:border-0 file:text-sm file:bg-[#EAEAEA]"
                            accept=".png, .jpg, .jpeg, .tiff, .tif"/>
                            <p class="text-xs text-gray-400 mb-7 mt-1">Accepts formats such as JPEG, PNG, BMP, TIFF, and must not exceed into 2MB.</p>
                            @error('profile_picture')
                                <p class="text-xs text-red-700 -mt-6">{{$message}}</p>
                            @enderror
                            <label for="email" class="text-sm font-medium">Work Email</label>
                            <input type="text" name="email" id="email" placeholder="Enter the work email" class="mt-2 mb-7 w-full border-[1px] border-black p-2 text-sm rounded-sm" required value="{{old('email')}}">
                            @error('email')
                            <p class="text-xs text-red-700 -mt-6">{{$message}}</p>
                            @enderror
                            <label for="password" class="text-sm font-medium">Default Password</label>
                            <div class="relative">
                                <input type="password" name="password" id="password" class="mt-2 w-full bg-gray-200 p-2 text-sm rounded-sm focus:outline-none focus:ring focus:border-blue-300" value="{{$password}}" readonly>
                                <i id="togglePassword" class="absolute top-1/2 mt-1.5 right-2 transform -translate-y-1/2 cursor-pointer far fa-eye text-gray-400"></i>
                            </div>
                            
                            <div class="mt-4 flex items-center gap-x-2">
                            <input type="checkbox" id="superuser" name="superuser" value="1" class="w-4 h-4 bg-gray-100 border-gray-300" {{ old('superuser') ? 'checked' : '' }}>
                            <label for="superuser" class="text-sm font-medium">Set as Admin</label>
                            </div>
            
                </div>
                <div class="w-1/2 p-10">
                            <label for="first_name" class="text-sm font-medium">First Name</label>
                            <input type="text" name="first_name" id="first_name" placeholder="Enter the first name" class="mt-2 mb-7 w-full border-[1px] border-black p-2 text-sm rounded-sm" required value="{{old('first_name')}}"
                            pattern="[A-Za-z -]+"
                            title="The input type accepts letters, hypen, and spaces only.">
                            @error('first_name')
                                <p class="text-xs text-red-700 -mt-6">{{$message}}</p>
                            @enderror

                            <label for="middle_name" class="text-sm font-medium">Middle Name</label>
                            <input type="text" name="middle_name" id="middle_name" placeholder="Enter the middle name" class="mt-2 mb-7 w-full border-[1px] border-black p-2 text-sm rounded-sm" value="{{old('middle_name')}}"
                            pattern="[A-Za-z -]+"
                            title="The input type accepts letters, hypen, and spaces only.">
                            @error('middle_name')
                            <p class="text-xs text-red-700 -mt-6">{{$message}}</p>
                            @enderror

                            <label for="last_name" class="text-sm font-medium">Last Name</label>
                            <input type="text" name="last_name" id="last_name" placeholder="Enter the last name" class="mt-2 mb-7 w-full border-[1px] border-black p-2 text-sm rounded-sm" required value="{{old('last_name')}}"
                            pattern="[A-Za-z -]+"
                            title="The input type accepts letters, hypen, and spaces only.">
                            @error('last_name')
                                <p class="text-xs text-red-700 -mt-6">{{$message}}</p>
                            @enderror

                            <label for="company_id" class="text-sm font-medium">Company</label>
                            <select id="company_id" name="company_id" class="mt-2 mb-7 w-full border-[1px] border-black p-2 text-sm rounded-sm" required>
                                <option value="" {{ old('company_id') == "" ? 'selected' : '' }}>Select the company</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>{{ $company->name }}</option>
                                @endforeach
                            </select>
                        
                            <label for="department" class="text-sm font-medium">Department</label>
                            <select name="department_id" id="department" class="mt-2 mb-7 w-full border-[1px] border-black p-2 text-sm rounded-sm" required>
                                <option value="" {{ old('department_id') == "" ? 'selected' : '' }}>Select the department</option>
                                @foreach($departments as $department)
                                <option value="{{$department->id}}" {{ old('department_id') == $department->id ? 'selected' : ''}}>{{$department->name}}</option>
                              @endforeach
                            </select>
            
                            <label for="position" class="text-sm font-medium">Position</label>
                            <input type="text" name="position" id="position" placeholder="Enter the position" class="mt-2 mb-7 w-full border-[1px] border-black p-2 text-sm rounded-sm" required value="{{old('position')}}"
                            pattern="[A-Za-z -]+"
                            title="The input type accepts letters, hypen, and spaces only.">
                            @error('position')
                                <p class="text-xs text-red-700 -mt-6">{{$message}}</p>
                            @enderror
                    
                            <div class="flex flex row gap-x-2 justify-end mr-2">
                                <button id="cancelButton" class="w-24 p-2 mt-5 border border-custom-orange rounded-sm text-sm font-semibold hover:bg-orange-500 hover:text-white">Cancel</button>
                                <button type="submit" class="w-24 p-2 mt-5 bg-custom-orange rounded-sm text-white text-sm font-semibold hover:bg-orange-500">Create</button>
                            </div>
                </form>
                
                </div>
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

});
</script>
@include('partials.footer')