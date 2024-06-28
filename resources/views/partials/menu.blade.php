<nav class="bg-white">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-4 p-4">
      <a href="#" class="flex items-center">
          <img src="../images/logo-name.png" class="w-28 h-12 fixed" alt="adish Logo" />
      </a>
        <div class=" w-1/5 flex flex-row gap-x-3 -mr-52">
          {{-- fetching user or customers profile picture --}}
          {{-- @if ($profile_picture)
              <img src="{{ asset('storage/' . $profile_picture) }}" class="w-10 h-10" alt="Profile Picture" />
          @else
              <img src="{{ asset('images/user.png') }}" class="w-10 h-10" alt="Default Profile Picture" />
          @endif --}}
          <img src="{{ asset('images/user.png') }}" class="w-10 h-10" alt="Default Profile Picture" />
          <div class="flex flex-col">
            <p class="text-sm font-medium">{{ $name }}</p>
            <p class="text-sm">{{ $position }} <span> at </span> {{ $company }}</p>
          </div>
        </div>
    </div>
</nav>