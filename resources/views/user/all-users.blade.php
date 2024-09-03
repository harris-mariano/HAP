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
            <p class="text-sm font-semibold">All Users</p>
            <a href="{{ route('users.create') }}" class="p-2 rounded-sm ml-auto text-sm font-semibold text-custom-orange mr-1 hover:bg-custom-orange hover:text-white">Create New
            </a> 
        </div>
            <div class="relative flex items-center mt-5">
                <input type="text" id="searchUser" placeholder="Type a name here" class="bg-gray-100 p-2 pr-10 text-sm rounded-sm w-full">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="absolute right-3 h-5 w-5">
                  <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
            </div>
            <div class="relative overflow-x-auto mt-5">
                <table id="usersTable"  class="w-full text-sm text-left rtl:text-right">
                    <thead class="text-xs text-gray-700 uppercase border-b border-t">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Picture
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Name
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Email
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Company
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Department
                            </th>
                            <th scope="col" class="px-6 py-3">
                               Position
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Role
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Status
                            </th>
                             <th scope="col" class="px-6 py-3">
                                Action
                             </th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($allUsers as $user)
                    <tr class="border-b">
                        <td class="px-6 py-4">
                            @if ($user->profile_picture)
                            <img src="{{ asset('storage/' . $user->profile_picture) }}" class="w-10 h-10 mb-3 mt-2 rounded-full object-cover" alt="Profile Picture" />
                            @else
                            <img src="{{ asset('images/user.png') }}" class="w-10 h-10" alt="Default Profile Picture" />
                            @endif
                        </td>
                        <td class="px-6 py-4">{{ $user->first_name }} {{ $user->last_name }}</td>
                        <td class="px-6 py-4">{{ $user->email }}</td>
                        <td class="px-6 py-4">{{ $user->company->name }}</td>
                        <td class="px-6 py-4">{{ $user->department->name }}</td>
                        <td class="px-6 py-4">{{ $user->position }}</td>
                        <td class="px-6 py-4">{{ $user->role->role }}</td>
                        <td class="px-6 py-4">
                            @if ($user->type_id == 1)
                                <span class="inline-block bg-resolved rounded-full py-1.5 w-full text-white text-center">{{ $user->type->type }}</span>
                            @elseif ($user->type_id == 2)
                                <span class="inline-block bg-closed rounded-full py-1.5 w-full text-white text-center">{{ $user->type->type }}</span>
                            @else
                            {{ $user->type->type }}
                            @endif
                        </td>

                        <td class="px-6 py-4">
                            <a href="{{ route('show.profile', ['id' => $user->id]) }}" class="p-2 font-medium text-in-progress rounded-sm hover:bg-in-progress hover:text-white">View</a>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="mt-5">
                    {{ $allUsers->links() }}
                </div>
            </div>       
      </div>
    </div>

   <script>
    document.addEventListener("DOMContentLoaded", function() {

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
});
</script>
@include('partials.footer')