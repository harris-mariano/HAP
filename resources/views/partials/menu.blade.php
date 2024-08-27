<header class="bg-white fixed top-0 left-0 w-full z-10 h-16 p-1">
    <div class="flex flex-wrap items-center justify-between mx-5 p-3">
      <a href= "{{route('user.dashboard')}}" class="flex items-center">
          <img src="../images/logo-name.png" class="w-28 h-12 fixed" alt="adish Logo" />
      </a>
      @auth('user')
        <div class=" w-1/4 flex flex-row gap-x-3 items-center">
          @if (Auth::guard('user')->user()->profile_picture)
          <img src="{{ asset('storage/' . Auth::guard('user')->user()->profile_picture) }}" class="w-10 h-10 rounded-full object-cover" alt="Profile Picture" />
          @else
          <img src="{{ asset('images/user.png') }}" class="w-10 h-10" alt="Default Profile Picture" />
          @endif
          <a href="{{route('view.profile')}}">
          <div>
                <p class="text-sm font-medium">{{ Auth::guard('user')->user()->first_name }} {{ Auth::guard('user')->user()->last_name }}</p>
                <p class="text-sm">{{ Auth::guard('user')->user()->position }} at {{ Auth::guard('user')->user()->company->name }}</p> 
        </div>
      </a>
        </div>
        @endauth
    </div>
</header>