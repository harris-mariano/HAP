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
        <p class="font-semibold text-sm">Verification Link Sent</p>
        <p class="text-sm">Please click on the link that has been sent on your email address to reset your account's password.</p>
        <p class="text-sm">Kindly remember that the link is only valid for the next hour. If you haven't received your verification email or it has expired, request a new verification link again.</p>

        <div class="flex flex-col mt-5 gap-y-2 justify-center items-center">
            <a href="http://127.0.0.1:8000/dashboard/user" class="p-2 w-1/2 rounded-sm text-sm text-white font-semibold text-center bg-blue-500">Go Back</a>
            <p class="text-sm text-center mt-10">Need help? <a href="mailto:helpdesk@adish.com.ph" class="text-custom-orange underline">Contact us</a>.</p>
        </div>
    </div>
</div>

@include('partials.footer')