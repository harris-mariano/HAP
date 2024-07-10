@include('partials.header', ['title' => 'adish HAP | Ticket Attachment'])
<div class="w-full bg-black opacity-80 px-28 py-10">
    <p class="text-white text-sm mb-2 ml-1">{{$attachment->file_name}}</p>
    <img src="{{ asset($attachment->file_path) }}" alt="Attachment Preview" class="object-cover shadow">
</div>
@include('partials.footer') 