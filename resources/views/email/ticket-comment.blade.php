@include('partials.header', ['title' => 'adish HAP | Ticket Discussion'])
<div class="relative flex items-center justify-center h-16 mt-20">
    <div class="absolute top-0 flex items-center justify-center rounded-full bg-white h-16 w-16">
        <div class="text-custom-orange text-4xl">
            <i class="fas fa-envelope"></i>
        </div>
    </div>
</div>
<div class="w-full p-10 flex flex-col justify-center items-center -mt-16">
    <div class="w-1/2 bg-custom-gray rounded-sm text-center flex flex-col gap-y-10 py-10 px-20">
        <p class="font-semibold text-sm">Ticket Discussion</p>
        <p class="text-sm">Hello <span class="font-medium">{{ $name }}</span>, a new comment was added on the ticket named <span class="font-medium">{{ $title }}</span>. </p>
        <p class="text-sm"><span class="font-medium">{{ $commenter }}</span> commented <span>"{{ $comment }}"</span>.</p>
        <a href="http://127.0.0.1:8000/tickets/{{$ticketId}}" class="bg-custom-orange text-white font-semibold text-sm p-2 rounded-sm">Reply in adish HAP</a>
        <p class="text-sm mt-3">Have questions? <span class="text-custom-orange">Just hit reply</span>.</p>

        <div class="flex flex-col">
            <p class="text-sm">Our Best,</p>
            <p class="text-sm font-medium">adish HAP Team</p>
        </div>
    </div>
</div>
@include('partials.footer')