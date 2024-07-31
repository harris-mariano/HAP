@include('partials.header', ['title' => 'adish HAP | Individual Departments'])
@include('partials.menu')
<div class="flex flex-row gap-x-10 pt-24">
    <div class="flex-none">
      @include('partials.sidebar')
    </div>
    <div class="sm:ml-64 w-full min-h-screen flex flex-col bg-custom-gray p-5 gap-5">
        @include('components.messages')
        <div class="w-full bg-white p-5 rounded-lg shadow">
            <form action="{{ route('companies.store') }}" method="POST">
                @csrf
                <div class="p-5 flex flex-col gap-y-3">
                    <p class="text-sm font-semibold">Create a New Company</p>
                    <div>
                        <label for="name" class="text-sm font-medium">Company Name:</label>
                        <input type="text" name="name" id="name" class="mt-2 mb-5 w-full border-[1px] border-black p-2 text-sm rounded-sm" placeholder="Enter the company name" required>
                        @error('name')
                        <p class="text-xs text-red-700 mt-2">{{$message}}</p>
                        @enderror
                    </div>
                </div>
                <div class="flex flex row gap-x-2 justify-end mr-5">
                    <button id="cancelButton" class="w-24 p-2 mt-5 border border-custom-orange rounded-sm text-sm font-semibold">Cancel</button>
                    <button type="submit" class="w-24 p-2 mt-5 bg-custom-orange rounded-sm text-white text-sm font-semibold">Create</button>
                </div>
            </form>
        </div>

        <div class="w-full bg-white p-5 rounded-lg shadow">
                <form action="{{ route('departments.store') }}" method="POST">
                    @csrf
                    <div class="p-5 flex flex-col gap-y-3">
                        <p class="text-sm font-semibold">Create a New Department</p>
                        <div>
                            <label for="company" class="text-sm font-medium">Company:</label>
                            <select id="company" name="company" class="mt-2 mb-7 w-full border-[1px] border-black p-2 text-sm rounded-sm" required>
                                <option value="" {{ old('company') == "" ? 'selected' : '' }}>Select the company</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}" {{ old('company') == $company->id ? 'selected' : '' }}>{{ $company->name }}</option>
                                @endforeach
                            </select>
                    
                        <label for="department" class="text-sm font-medium">Department:</label>
                        <input type="text" name="department" id="department" class="mt-2 mb-5 w-full border-[1px] border-black p-2 text-sm rounded-sm" placeholder="Enter the department name"required>
                        @error('department')
                        <p class="text-xs text-red-700 mt-2">{{$message}}</p>
                        @enderror
                        </div>
                    </div>
                    <div class="flex flex row gap-x-2 justify-end mr-5">
                        <button id="cancelButton" class="w-24 p-2 mt-5 border border-custom-orange rounded-sm text-sm font-semibold">Cancel</button>
                        <button type="submit" class="w-24 p-2 mt-5 bg-custom-orange rounded-sm text-white text-sm font-semibold">Create</button>
                    </div>
                </form>
            </div>

    </div>
@include('partials.footer')