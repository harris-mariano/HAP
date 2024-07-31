@include('partials.header', ['title' => 'adish HAP | Reset Password Request'])
<div class="relative flex items-center justify-center h-16 mt-20">
    <div class="absolute top-0 flex items-center justify-center rounded-full bg-white h-16 w-16">
        <div class="text-custom-orange text-4xl">
            <i class="fas fa-envelope"></i>
        </div>
    </div>
</div>
<div class="w-full p-10 flex flex-col justify-center items-center -mt-16">
    <div class="w-1/2 bg-custom-gray rounded-sm text-center flex flex-col gap-y-10 py-10 px-20">
        <p class="font-semibold text-sm">Password Changed</p>
        <p class="text-sm">Hello <span class="font-medium">{{ $name }}</span>, we wanted to give you a notice that your password has been recently changed.</p>
        <p class="text-sm">You can <span class="underline text-custom-orange"><a href="http://127.0.0.1:8000/">log in</a></span> with your new password. If you requested this change, you can disregard this email. If you did not request this change, 
            please reply to this email, and we will assist you further.</p>
        <p class="text-sm mt-3">Have questions? <span class="text-custom-orange">Just hit reply</span>.</p>

        <div class="flex flex-col">
            <p class="text-sm">Our Best,</p>
            <p class="text-sm font-medium">adish HAP Team</p>
        </div>
    </div>
</div>
@include('partials.footer')