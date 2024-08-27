@include('partials.header', ['title' => 'adish HAP | Individual Departments'])
@include('partials.menu')
<div class="flex flex-row gap-x-10 pt-20">
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
                        <label for="name" class="text-sm font-medium">Company</label>
                        <input type="text" name="name" id="name" class="mt-2 mb-5 w-full border-[1px] border-black p-2 text-sm rounded-sm" placeholder="Enter the company name" required>
                        @error('name')
                        <p class="text-xs text-red-700 -mt-4">{{$message}}</p>
                        @enderror
                    </div>
                </div>
                <div class="flex flex row gap-x-2 justify-end mr-5">
                    <button id="cancelCompany" class="w-24 p-2 mt-5 border border-custom-orange rounded-sm text-sm font-semibold hover:bg-orange-500 hover:text-white">Cancel</button>
                    <button type="submit" class="w-24 p-2 mt-5 bg-custom-orange rounded-sm text-white text-sm font-semibold hover:bg-orange-500">Create</button>
                </div>
            </form>
        </div>

        <div class="w-full bg-white p-5 rounded-lg shadow">
                <form action="{{ route('departments.store') }}" method="POST">
                    @csrf
                    <div class="p-5 flex flex-col gap-y-3">
                        <p class="text-sm font-semibold">Create a New Department</p>
                        <div>
                            <label for="company" class="text-sm font-medium">Company</label>
                            <select id="company" name="company" class="mt-2 mb-7 w-full border-[1px] border-black p-2 text-sm rounded-sm" required>
                                <option value="" {{ old('company') == "" ? 'selected' : '' }}>Select the company</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}" {{ old('company') == $company->id ? 'selected' : '' }}>{{ $company->name }}</option>
                                @endforeach
                            </select>
                            <div id="department-container">
                            <div class="form-group">
                                <label for="department_0" class="text-sm font-medium">Department</label>
                                <input type="text"name="departments[0][name]" id="department_0" class="mt-2 mb-2 w-full border-[1px] border-black p-2 text-sm rounded-sm" placeholder="Enter the department name"required>
                                 @error('departments.*.name')
                                 <p class="text-xs text-red-700">{{$message}}</p>
                                 @enderror
                            </div>
                        </div>
                        <button id="add-department" class="text-sm text-custom-orange font-medium hover:text-orange-500">Add Another Department</button>
                    </div>
                    </div>
                    <div class="flex flex row gap-x-2 justify-end mr-5">
                        <button id="cancelDepartment" class="w-24 p-2 mt-5 border border-custom-orange rounded-sm text-sm font-semibold hover:bg-orange-500 hover:text-white">Cancel</button>
                        <button type="submit" class="w-24 p-2 mt-5 bg-custom-orange rounded-sm text-white text-sm font-semibold hover:bg-orange-500">Create</button>
                    </div>
                </form>
            </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var cancelCompany = document.getElementById("cancelCompany");
    cancelCompany.addEventListener("click", function(){
        document.getElementById('name').value = "";
    });

    var cancelDepartment = document.getElementById("cancelDepartment");
    cancelDepartment.addEventListener("click", function(){
        var clearElements = ["department", "company"];
        clearElements.forEach(function(elementId) {
            document.getElementById(elementId).value = "";
        });
    });

    let departmentIndex = 1;
    
    document.getElementById('add-department').addEventListener('click', function () {
        const container = document.getElementById('department-container');
        const newField = document.createElement('div');
        newField.classList.add('form-group');
        newField.innerHTML = `
                <div style="flex items-center">
                    <label for="department_${departmentIndex}" class="text-sm font-medium mr-5">Department Name:</label>
                    <button type="button" class="close-button text-closed font-medium text-sm hover:text-red-700">Remove</button>
                </div>
                <input type="text" name="departments[${departmentIndex}][name]" id="department_${departmentIndex}" class="mt-2 mb-2 w-full border-[1px] border-black p-2 text-sm rounded-sm" placeholder="Enter the department name" required>
                @error('departments.*.name')
                    <p class="text-xs text-red-700">{{$message}}</p>
                @enderror
            `;
        container.appendChild(newField);
        departmentIndex++;

        newField.querySelector('.close-button').addEventListener('click', function () {
                container.removeChild(newField);
            });
    });
})
</script>
@include('partials.footer')