@include('partials.header', ['title' => 'adish HAP | My Profile'])
@include('partials.menu')
<div class="flex flex-row gap-x-10 pt-20">
    <div class="flex-none">
      @include('partials.sidebar')
    </div>
    <div class="sm:ml-64 w-full flex flex-col gap-x-5 bg-custom-gray p-5">
      @include('components.messages')
        <div class="w-full bg-white p-5 rounded-lg shadow">
            <p class="text-sm font-semibold">My Personal Information</p>
            @auth('user')
            <form action="{{ route('update.profile') }}" method="POST" enctype="multipart/form-data">
              @method('PUT')
              @csrf
              <div class="flex flex-col items-center justify-center">
                <label for="profile_picture" class="text-sm font-medium">Profile Picture</label>
                @if (Auth::guard('user')->user()->profile_picture && Auth::guard('user')->user()->is_google_login)
                    <img id="profile_picture_preview" src="{{ Auth::guard('user')->user()->profile_picture }}" class="w-20 h-20 mb-3 mt-2 rounded-full object-cover" alt="Profile Picture" />
                @elseif (Auth::guard('user')->user()->profile_picture && !Auth::guard('user')->user()->is_google_login)
                    <img id="profile_picture_preview" src="{{ Auth::guard('user')->user()->profile_picture ? asset('storage/' . Auth::guard('user')->user()->profile_picture) : asset('images/user.png') }}" class="w-20 h-20 mb-3 mt-2 rounded-full object-cover" alt="Profile Picture" />
                @endif

                @if (Auth::guard('user')->user()->profile_picture && !Auth::guard('user')->user()->is_google_login)
                <input type="file" name="profile_picture" id="profile_picture" class="text-sm file:mr-2 file:py-2 file:px-3 file:rounded-sm file:border-0 file:text-sm file:bg-[#EAEAEA]" accept=".png, .jpg, .jpeg, .tiff, .tif">
                <p class="text-xs text-gray-400 mb-5 mt-1">Accepts formats such as JPEG, PNG, BMP, TIFF, and must not exceed into 2MB.</p>
                @error('profile_picture')
                    <p class="text-xs text-red-700 -mt-5">{{$message}}</p>
                @enderror
                @endif
            </div>
            <div class="grid grid-cols-2 gap-x-24 px-2 py-3">
                <div class="flex flex-col">
                    <label for="first_name" class="text-sm font-medium">First Name</label>
                    @if(!Auth::guard('user')->user()->first_name)
                    <input type="text" name="first_name" id="first_name" class="mt-2 mb-7 w-full border border-black p-2 text-sm rounded-sm" value="{{  Auth::guard('user')->user()->first_name }}"
                    pattern="[A-Za-z -]+"
                    title="The input type accepts letters, hypen, and spaces only.">
                    @error('first_name')
                    <p class="text-xs text-red-700 -mt-6">{{$message}}</p>
                    @enderror
                    @else
                    <input type="first_name" name="first_name" id="first_name" class="mt-2 mb-7 w-full bg-[#EAEAEA] p-2 text-sm rounded-sm" value="{{ Auth::guard('user')->user()->first_name }}" readonly>
                    @endif
                  </div>
                  <div class="flex flex-col">
                    <label for="email" class="text-sm font-medium">Work Email</label>
                    <input type="email" name="email" id="email" class="mt-2 mb-7 w-full bg-[#EAEAEA] p-2 text-sm rounded-sm" value="{{ Auth::guard('user')->user()->email }}" readonly>
                  </div>
                  <div class="flex flex-col">
                    <label for="middle_name" class="text-sm font-medium">Middle Name</label>
                    @if(!Auth::guard('user')->user()->middle_name)
                    <input type="text" name="middle_name" id="middle_name" class="mt-2 mb-7 w-full border border-black p-2 text-sm rounded-sm" placeholder="Enter your middle name here" value="{{  Auth::guard('user')->user()->middle_name }}"
                    pattern="[A-Za-z -]+"
                    title="The input type accepts letters, hypen, and spaces only.">
                    @error('middle_name')
                    <p class="text-xs text-red-700 -mt-6">{{$message}}</p>
                    @enderror
                    @else
                    <input type="middle_name" name="middle_name" id="middle_name" class="mt-2 mb-7 w-full bg-[#EAEAEA] p-2 text-sm rounded-sm" value="{{ Auth::guard('user')->user()->middle_name }}" readonly>
                    @endif
                  </div>
                  <div class="flex flex-col">
                    <label for="company" class="text-sm font-medium">Company</label>
                    <input type="text" name="company" id="company" class="mt-2 mb-7 w-full bg-[#EAEAEA] p-2 text-sm rounded-sm" value="{{ Auth::guard('user')->user()->company->name }}" readonly>
                  </div>
                  <div class="flex flex-col">
                    <label for="last_name" class="text-sm font-medium">Last Name</label>
                    @if(!Auth::guard('user')->user()->last_name)
                    <input type="text" name="last_name" id="last_name" class="mt-2 mb-7 w-full border border-black p-2 text-sm rounded-sm" value="{{ Auth::guard('user')->user()->last_name }}"
                    pattern="[A-Za-z -]+"
                    title="The input type accepts letters, hypen, and spaces only.">
                    @error('last_name')
                    <p class="text-xs text-red-700 -mt-6">{{$message}}</p>
                  @enderror
                  @else
                  <input type="last_name" name="last_name" id="last_name" class="mt-2 w-full bg-[#EAEAEA] p-2 text-sm rounded-sm" value="{{ Auth::guard('user')->user()->last_name }}" readonly>
                  @endif
                  </div>
                  <div class="flex flex-col">
                    <label for="position" class="text-sm font-medium">Position</label>
                    <input type="text" name="position" id="position" class="mt-2 w-full bg-[#EAEAEA] p-2 text-sm rounded-sm" value="{{ Auth::guard('user')->user()->position }}" readonly>
                  </div>
            </div>
            <div class="flex flex row gap-x-2 justify-end mr-2">
                {{-- <a href="{{ route('view.reset') }}" class="w-32 p-2 mt-5 bg-in-progress rounded-sm text-white text-sm text-center font-semibold hover:bg-blue-600">Reset Password</a> --}}
                <button type="submit" class="w-32 p-2 mt-5 bg-custom-orange rounded-sm text-white text-sm font-semibold hover:bg-orange-500">Update Profile</button>
            </div>
          </form>
          @endauth
        </div>

        @if (Auth::guard('user')->user()->profile_picture && !Auth::guard('user')->user()->is_google_login)
        <div class="w-full bg-white p-5 rounded-lg shadow mt-8">
          <p class="text-sm font-semibold">Change Password</p>
          <form action="/update/password" method="POST">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-2 gap-x-24 px-2 py-3">
              <div>
                <label for="password" class="text-sm font-medium">New Password</label>
            <div class="relative">
                <input type="password" name="password" id="password" placeholder="Enter your new password" class="mt-2 mb-4 w-full border-[1px] border-black p-2 text-sm rounded-sm">
                <i class="togglePassword absolute top-1/3 right-2 transform -translate-y-1/2 cursor-pointer far fa-eye text-gray-400"></i>
                <p class="text-xs text-gray-400 -mt-3">Passwords must be 8 characters long, and must contain one lowercase letter, one uppercase letter, one number, and one symbol.  </p>
            </div>
            @error('password')
            <p class="text-xs text-red-700">{{$message}}</p>
            @enderror
              </div>

              <div>
                <label for="password_confirmation" class="text-sm font-medium">Confirm Password</label>
            <div class="relative">
                <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Re-type your new password" class="mt-2 mb-4 w-full border-[1px] border-black p-2 text-sm rounded-sm">
                <i class="togglePassword absolute top-1/2 -mt-1 right-2 transform -translate-y-1/2 cursor-pointer far fa-eye text-gray-400"></i>
            </div>
            @error('password_confirmation')
            <p class="text-xs text-red-700 -mt-4">{{$message}}</p>
            @enderror
              </div>
            </div>
            <div class="flex flex row gap-x-2 justify-end mr-2">
            <button type="submit" class="w-32 p-2 mt-5 bg-custom-orange rounded-sm text-white text-sm font-semibold hover:bg-orange-500">Change Password</button>
            </div>
        </form>
      </div>
    @endif

    </div>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
          function sanitizeInput(event) {
              event.target.value = event.target.value.replace(/[^A-Za-z\s-]/g, '');
          }

          const inputs = [
              document.getElementById('first_name'),
              document.getElementById('middle_name'),
              document.getElementById('last_name')
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

    const togglePasswordIcons = document.querySelectorAll('.togglePassword');

    togglePasswordIcons.forEach(icon => {
        icon.addEventListener('click', function() {
            const passwordField = this.previousElementSibling;
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    });
    });
      </script>
@include('partials.footer')
