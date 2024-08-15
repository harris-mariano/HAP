@include('partials.header', ['title' => 'adish HAP | Reset Password'])
@include('partials.nav')
<div class="relative flex items-center justify-center h-16">
    <div class="absolute top-0 flex items-center justify-center rounded-full bg-white h-16 w-16">
        <div class="text-custom-orange text-4xl">
            <i class="fas fa-envelope"></i>
        </div>
    </div>
</div>
<div class="w-full px-10 flex flex-col justify-center items-center -mt-5">
    <div class="w-1/3 bg-custom-gray text-center flex flex-col gap-y-8 p-10">
        <p class="font-semibold text-sm">Reset Password</p>
        <p class="text-sm">Enter your email address associated with your account, and we will send you a link to reset your password. </p>

        <div class="text-left px-2">
            <form action="{{route('send.email')}}" method="POST">
                @csrf
                <label for="email" class="text-sm font-medium">Work Email</label>
                <div class="relative mb-3">
                    <input type="email" name="email" id="email" placeholder="Enter your work email" class="mt-2 mb-4 w-full border-[1px] border-black p-2 text-sm rounded-sm">
                </div>
                @error('email')
                <p class="text-xs text-red-700 -mt-5">{{$message}}</p>
                @enderror

                <div class="flex flex-col mt-5 gap-y-2 justify-center items-center">
                <button type="submit" class="p-2 w-1/2 bg-custom-orange rounded-sm text-white text-sm font-semibold hover:bg-orange-500">Send Link</button>
                <button type="button" onclick="window.history.back()" class="p-2 w-1/2 rounded-sm text-sm border border-custom-orange font-semibold hover:bg-orange-500 hover:text-white">Go Back</button>
                <p class="text-sm text-center mt-10">Need help? <a href="{{route('view.contact')}}" class="text-custom-orange underline">Contact us</a>.</p>
                </div>
            </form>
            </div>
    </div>
</div>

@include('partials.footer')