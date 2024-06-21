@include('partials.header', ['title' => 'adish HAP | User Forms'])
@include('partials.nav')
<div class="px-12 text-sm font-medium text-center text-gray-500 border-b border-gray-200">
    <ul class="flex flex-wrap -mb-px">
        <li class="me-2">
            <a href="/user/forms" class="inline-block p-4 text-custom-orange border-b-2 border-custom-orange rounded-t-lg">Create New User</a>
        </li>
        <li class="me-2">
            <a href="/customer/forms" class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300">Create New Customer</a>
        </li>
    </ul>
</div>
<div class="bg-custom-gray">
<div class="flex flex-row flex justify-around mx-10">
    <div class="w-1/3 p-10 ">
        <form action="/user/register" method="POST" enctype="multipart/form-data">
            @csrf
                <label for="profile_picture" class="text-sm">Profile Picture</label>
                <img src="../images/user.png" alt="Default Profile Picture" class="w-20 h-20 mb-3 mt-2">
                <input type="file"  name="profile_picture" id="profile_picture" class="w-full text-sm file:mr-2 file:py-2 file:px-3 file:rounded-sm file:border-0 file:text-sm file:bg-[#EAEAEA]"/>
                <p class="text-xs text-gray-400 mb-5 mt-1">Accepts formats such as JPEG, PNG, BMP, TIFF, and must not exceed into 2MB.</p>
                @error('profile_picture')
                    <p class="text-xs text-red-700 mt-2">{{$message}}</p>
                @enderror

                <label for="email" class="text-sm">Work Email</label>
                <input type="text" name="email" id="email" placeholder="Enter the work email" class="mt-2 mb-4 w-full border-[1px] border-black p-2 text-sm rounded-sm" required>
                @error('email')
                <p class="text-xs text-red-700 mt-2">{{$message}}</p>
                @enderror
                
                <label for="password" class="text-sm">Default Password</label>
                <div class="relative">
                    <input type="password" name="password" id="password" class="mt-2 w-full bg-gray-200 p-2 text-sm rounded-sm focus:outline-none focus:ring focus:border-blue-300" value="{{$password}}" readonly>
                    <i id="togglePassword" class="absolute top-1/2 mt-1.5 right-2 transform -translate-y-1/2 cursor-pointer far fa-eye text-gray-400"></i>
                </div>

    </div>
    <div class="w-1/3 p-10">
                <label for="first_name" class="text-sm">First Name</label>
                <input type="text" name="first_name" id="first_name" placeholder="Enter the first name" class="mt-2 mb-7 w-full border-[1px] border-black p-2 text-sm rounded-sm" required value="{{old('first_name')}}">
                @error('first_name')
                    <p class="text-xs text-red-700 mt-2">{{$message}}</p>
                @enderror

                <label for="middle_name" class="text-sm">Middle Name</label>
                <input type="text" name="middle_name" id="middle_name" placeholder="Enter the middle name" class="mt-2 mb-7 w-full border-[1px] border-black p-2 text-sm rounded-sm" value="{{old('middle_name')}}">

                <label for="last_name" class="text-sm">Last Name</label>
                <input type="text" name="last_name" id="last_name" placeholder="Enter the last name" class="mt-2 mb-7 w-full border-[1px] border-black p-2 text-sm rounded-sm" required value="{{old('last_name')}}">
                @error('last_name')
                    <p class="text-xs text-red-700 mt-2">{{$message}}</p>
                @enderror
                
                <label for="company" class="text-sm">Company</label>
                <input type="text" name="company" id="company" class="mt-2 mb-7 w-full bg-[#EAEAEA] p-2 text-sm rounded-sm" value="adish International Corporation" readonly>
            
                <label for="department" class="text-sm">Department</label>
                <select name="department" id="department" class="mt-2 mb-7 w-full border-[1px] border-black p-2 text-sm rounded-sm" required>
                    <option value="" {{ old('department') == "" ? 'selected' : '' }}>Select the department</option>
                    <option value="HRAD" {{ old('department') == "HRAD" ? 'selected' : '' }}>HRAD</option>
                    <option value="Team Banana" {{ old('department') == "Team Banana" ? 'selected' : '' }}>Team Banana</option>
                </select>
                @error('department')
                <p class="text-xs text-red-700 mt-2">{{$message}}</p>
                @enderror

                <label for="position" class="text-sm">Position</label>
                <input type="text" name="position" id="position" placeholder="Enter the position" class="mt-2 mb-7 w-full border-[1px] border-black p-2 text-sm rounded-sm" required value="{{old('position')}}">
                @error('position')
                    <p class="text-xs text-red-700 mt-2">{{$message}}</p>
                @enderror

                <div class="flex flex row gap-x-5">
                    <a id="cancelButton" href="#" class="w-full p-2 mt-5 text-sm text-right">Cancel</a>
                    <button type="submit" class="w-1/2 p-2 mt-5 bg-custom-orange rounded-sm text-white text-sm font-bold">Submit</button>
                </div>
    </form>
    
    </div>
</div>
</div>

<script>
    var cancelButton = document.getElementById("cancelButton");
    cancelButton.addEventListener("click", function(){
    var clearElements = ["profile_picture", "password", "confirm_password", "first_name", "middle_name", "last_name", "department", "position"];
        clearElements.forEach(function(elementId) {
        document.getElementById(elementId).value = "";
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

</script>
@include('partials.footer')