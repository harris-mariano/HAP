@include('partials.header', ['title' => 'adish HAP | Email Verification'])
<div class="relative flex items-center justify-center h-16 mt-20">
    <div class="absolute top-0 flex items-center justify-center rounded-full bg-white h-16 w-16">
        <div class="text-custom-orange text-4xl">
            <i class="fas fa-envelope"></i>
        </div>
    </div>
</div>
<div class="w-full p-10 flex flex-col justify-center items-center -mt-16">
    <div class="w-1/2 bg-custom-gray rounded-sm text-center flex flex-col gap-y-10 py-10 px-20">
        <p class="font-bold text-s m">Thank you for registering at adish HAP!</p>
        <p class="text-sm">This helpdesk app streamlines support tasks for teams, making it easy to address customer inquiries, resolve issues, and collaborate effectively for exceptional support experiences.</p>
        <p class="text-sm">By connecting your email <span class="font-semibold">({{ $email }})</span>, you will also receive notifications about the ticket that you have created.</p>
        <p class="text-sm mt-3">Have questions? <span class="text-custom-orange">Just hit reply</span>.</p>

        <div class="flex flex-col">
            <p class="text-sm">Our Best,</p>
            <p class="text-sm font-semibold">adish HAP Team</p>
        </div>
    </div>
</div>
@include('partials.footer')