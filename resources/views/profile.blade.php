@include('partials.header', ['title' => 'adish HAP | File Ticket'])
@include('partials.menu')
<div class="flex flex-row gap-x-10 pt-24">
    <div class="flex-none">
      @include('partials.sidebar')
    </div>
    <div class="sm:ml-64 w-full flex flex-col gap-x-5 bg-custom-gray p-5">
      @include('components.messages')
        <div class="w-full bg-white p-5 rounded-lg shadow">
            <p class="text-sm font-semibold">My Personal Information</p>
            <form action="{{ route('update.profile') }}" method="POST" enctype="multipart/form-data">
              @method('PUT')
              @csrf
            <div class="flex flex-col items-center justify-center">
                <label for="profile_picture" class="text-sm font-medium">Profile Picture</label>
                @auth('user')
                @if (Auth::guard('user')->user()->profile_picture)
                <img src="{{ asset('storage/' . Auth::guard('user')->user()->profile_picture) }}" class="w-20 h-20 mb-3 mt-2" alt="Profile Picture" />
                @else 
                <img src="{{ asset('images/user.png') }}" class="w-20 h-20 mb-3 mt-2" alt="Default Profile Picture" />
                @endif
                @elseauth('customer')
                @if (Auth::guard('customer')->user()->profile_picture)
                <img src="{{ asset('storage/' . Auth::guard('customer')->user()->profile_picture) }}" class="w-20 h-20 mb-3 mt-2" alt="Profile Picture" />
                @else
                <img src="{{ asset('images/user.png') }}" class="w-20 h-20 mb-3 mt-2" alt="Default Profile Picture" />
                @endif
                @endauth
                <input type="file" name="profile_picture" id="profile_picture" class="text-sm file:mr-2 file:py-2 file:px-3 file:rounded-sm file:border-0 file:text-sm file:bg-[#EAEAEA]">
                <p class="text-xs text-gray-400 mb-5 mt-1">Accepts formats such as JPEG, PNG, BMP, TIFF, and must not exceed into 2MB.</p>
                @error('profile_picture')
                    <p class="text-xs text-red-700 mt-2">{{$message}}</p>
                @enderror
            </div>
            <div class="grid grid-cols-2 gap-x-24 px-2 py-3">
                <div class="flex flex-col">
                    <label for="first_name" class="text-sm font-medium">First Name:</label>
                    @auth('user')
                    <input type="text" name="first_name" id="first_name" class="mt-2 mb-7 w-full border border-black p-2 text-sm rounded-sm" value="{{  Auth::guard('user')->user()->first_name }}">
                    @elseauth('customer')
                    <input type="text" name="first_name" id="first_name" class="mt-2 mb-7 w-full border border-black p-2 text-sm rounded-sm" value="{{  Auth::guard('customer')->user()->first_name }}">
                    @endauth
                  </div>
                  <div class="flex flex-col">
                    <label for="email" class="text-sm font-medium">Work Email:</label>
                    @auth('user')
                    <input type="email" name="email" id="email" class="mt-2 mb-7 w-full bg-[#EAEAEA] p-2 text-sm rounded-sm" value="{{ Auth::guard('user')->user()->email }}" readonly>
                    @elseauth('customer')
                    <input type="email" name="email" id="email" class="mt-2 mb-7 w-full bg-[#EAEAEA] p-2 text-sm rounded-sm" value="{{ Auth::guard('customer')->user()->email }}" readonly>
                    @endauth
                  </div>
                  <div class="flex flex-col">
                    <label for="middle_name" class="text-sm font-medium">Middle Name:</label>
                    @auth('user')
                    <input type="text" name="middle_name" id="middle_name" class="mt-2 mb-7 w-full border border-black p-2 text-sm rounded-sm" value="{{  Auth::guard('user')->user()->middle_name }}">
                    @elseauth('customer')
                    <input type="text" name="middle_name" id="middle_name" class="mt-2 mb-7 w-full border border-black p-2 text-sm rounded-sm" value="{{  Auth::guard('customer')->user()->middle_name }}">
                    @endauth
                  </div>
                  <div class="flex flex-col">
                    <label for="company" class="text-sm font-medium">Company:</label>
                    @auth('user')
                    <input type="text" name="company" id="company" class="mt-2 mb-7 w-full bg-[#EAEAEA] p-2 text-sm rounded-sm" value="{{ Auth::guard('user')->user()->company }}" readonly>
                    @elseauth('customer')
                    <input type="text" name="company" id="company" class="mt-2 mb-7 w-full bg-[#EAEAEA] p-2 text-sm rounded-sm" value="{{ Auth::guard('customer')->user()->company }}" readonly>
                    @endauth
                  </div>
                  <div class="flex flex-col">
                    <label for="last_name" class="text-sm font-medium">Last Name:</label>
                    @auth('user')
                    <input type="text" name="last_name" id="last_name" class="mt-2 mb-7 w-full border border-black p-2 text-sm rounded-sm" value="{{ Auth::guard('user')->user()->last_name }}">
                    @elseauth('customer')
                    <input type="text" name="last_name" id="last_name" class="mt-2 mb-7 w-full border border-black p-2 text-sm rounded-sm" value="{{ Auth::guard('customer')->user()->last_name }}">
                    @endauth
                  </div>
                  <div class="flex flex-col">
                    <label for="position" class="text-sm font-medium">Position:</label>
                    @auth('user')
                    <input type="text" name="position" id="position" class="mt-2 mb-7 w-full bg-[#EAEAEA] p-2 text-sm rounded-sm" value="{{ Auth::guard('user')->user()->position }}" readonly>
                    @elseauth('customer')
                    <input type="text" name="position" id="position" class="mt-2 mb-7 w-full bg-[#EAEAEA] p-2 text-sm rounded-sm" value="{{ Auth::guard('customer')->user()->position }}" readonly>
                    @endauth
                  </div>
            </div>
            <div class="flex justify-end gap-x-3">
                <a href=# class="w-32 p-2 mt-5 bg-in-progress rounded-sm text-white text-sm text-center font-semibold">Reset Password</a>
                <button type="submit" class="w-32 p-2 mt-5 bg-custom-orange rounded-sm text-white text-sm font-semibold">Update Profile</button>
            </div>
          </form>
        </div>    
    </div>
@include('partials.footer')