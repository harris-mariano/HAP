@include('partials.header', ['title' => 'adish HAP | Login'])
@include('partials.nav')
@include('components.messages')
    <div class="bg-custom-gray w-full flex flex-col py-32 items-center gap-y-10">
        <div class="w-1/4 text-center">
            <p class="text-4xl font-bold">Empowering support, one ticket at a time with adish HAP.</p>
        </div>
        <div class="w-1/4">
                <form method="POST" action="{{ url("login/user") }}">
            @csrf
                    <p class="text-sm font-medium">Work Email</p>
                    <input type="email" name="email" id="email" placeholder="Enter your work email" class="mt-2 mb-5 w-full border-[1px] border-black p-1.5 text-sm rounded-sm" required value={{old('email')}} >

                    <div class="flex items-center justify-between">
                        <label for="password" class="text-sm font-medium">Password</label>
                        <a href="{{ route('view.reset') }}" class="text-sm text-custom-orange font-medium hover:text-orange-500">Forgot password?</a>
                    </div>
                    <div class="relative mb-3">
                        <input type="password" name="password" id="password" placeholder="Enter your password" class="mt-2 w-full border-[1px] border-black p-1.5 text-sm rounded-sm">
                        <i id="togglePassword" class="absolute top-1/3 mt-3 right-2 transform -translate-y-1/2 cursor-pointer far fa-eye text-gray-400"></i>
                    </div>
                    @error('email')
                    <p class="text-xs text-red-700 -mt-2">{{$message}}</p>
                    @enderror
                    <button id="loginButton" type="submit" class="w-full p-2 mt-5 bg-custom-orange rounded-sm text-white text-sm font-semibold hover:bg-orange-500">Login</button>
            </form>
            <p class="text-sm text-center mt-3">No account yet? <a href="{{route('view.contact')}}" class="text-custom-orange underline hover:text-orange-500">Contact us</a>.</p>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const togglePassword = document.getElementById('togglePassword');
        const passwordField = document.getElementById('password');

        togglePassword.addEventListener('click', function() {
        const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordField.setAttribute('type', type);
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
        });
    });
    </script>
@include('partials.footer')