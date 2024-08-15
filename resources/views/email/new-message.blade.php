@include('partials.header', ['title' => 'adish HAP | New Message'])
<div class="relative flex items-center justify-center h-16 mt-20">
    <div class="absolute top-0 flex items-center justify-center rounded-full bg-white h-16 w-16">
        <div class="text-custom-orange text-4xl">
            <i class="fas fa-envelope"></i>
        </div>
    </div>
</div>
<div class="w-full p-10 flex flex-col justify-center items-center -mt-16">
    <div class="w-1/2 bg-custom-gray rounded-sm text-center flex flex-col gap-y-10 py-10 px-20">
        <p class="font-semibold text-sm">New Message</p>
        {{-- title is email --}}
        <p class="text-sm">Hello, you have received a new message from <span class="font-medium">{{ $name }}</span> with an email of <span class="font-medium">{{ $title }}</span>.</p>
        {{-- status is message --}}
        <p class="text-sm">The message says <span>"{{ $status }}"</span>.</p>

        <p class="text-sm">You are receiving this message from a form submission on the "Contact Page" of adish HAP.</p>
    </div>
</div>
@include('partials.footer')