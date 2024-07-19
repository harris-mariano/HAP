<header class="bg-white fixed top-0 left-0 w-full z-10">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-4 p-4">
      <a href="#" class="flex items-center">
          <img src="../images/logo-name.png" class="w-28 h-12 fixed" alt="adish Logo" />
      </a>
      @auth('user')
        <div class=" w-1/5 flex flex-row gap-x-3 -mr-52">
          @if (Auth::guard('user')->user()->profile_picture)
          <img src="{{ asset('storage/' . Auth::guard('user')->user()->profile_picture) }}" class="w-10 h-10" alt="Profile Picture" />
          @else
          <img src="{{ asset('images/user.png') }}" class="w-10 h-10" alt="Default Profile Picture" />
          @endif
          <div>
                <p class="text-sm font-medium">{{ Auth::guard('user')->user()->first_name }} {{ Auth::guard('user')->user()->last_name }}</p>
                <p class="text-sm">{{ Auth::guard('user')->user()->position }} at {{ Auth::guard('user')->user()->company }}</p> 
        </div>
        </div>
        @elseauth('customer')
        <div class=" w-1/5 flex flex-row gap-x-3 -mr-52">
          @if (Auth::guard('customer')->user()->profile_picture)
          <img src="{{ asset('storage/' . Auth::guard('customer')->user()->profile_picture) }}" class="w-10 h-10" alt="Profile Picture" />
          @else
          <img src="{{ asset('images/user.png') }}" class="w-10 h-10" alt="Default Profile Picture" />
          @endif
          <div>
                <p class="text-sm font-medium">{{ Auth::guard('customer')->user()->first_name }} {{ Auth::guard('customer')->user()->last_name }}</p>
                <p class="text-sm">{{ Auth::guard('customer')->user()->position }} at {{ Auth::guard('customer')->user()->company }}</p>
        </div>
        </div>
        @endauth
    </div>
</header>