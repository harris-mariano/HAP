<header class="bg-white fixed top-0 left-0 w-full z-10">
    <div class="flex flex-wrap items-center justify-between mx-4 p-4">
      <a href= "{{route('user.dashboard')}}" class="flex items-center">
          <img src="../images/logo-name.png" class="w-28 h-12 fixed" alt="adish Logo" />
      </a>
      @auth('user')
        <div class=" w-1/5 flex flex-row gap-x-3">
          @if (Auth::guard('user')->user()->profile_picture)
          <img src="{{ asset('storage/' . Auth::guard('user')->user()->profile_picture) }}" class="w-10 h-10 mb-3 mt-2 rounded-full object-cover" alt="Profile Picture" />
          @else
          <img src="{{ asset('images/user.png') }}" class="w-10 h-10" alt="Default Profile Picture" />
          @endif
          <div>
                <p class="text-sm font-medium">{{ Auth::guard('user')->user()->first_name }} {{ Auth::guard('user')->user()->last_name }}</p>
                <p class="text-sm">{{ Auth::guard('user')->user()->position }} at {{ Auth::guard('user')->user()->company->name }}</p> 
        </div>
        </div>
        @endauth
    </div>
</header>