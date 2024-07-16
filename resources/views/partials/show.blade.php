@include('partials.header', ['title' => 'adish HAP | Ticket Attachment'])
<div class="fixed inset-0 bg-black bg-opacity-80 flex justify-center items-center">
    <div class="w-full max-w-6xl px-6 py-10 object-cover shadow">
        <p class="text-white text-sm mb-2 ml-1">{{ $attachment->file_name }}</p>
        @if (Str::endsWith($attachment->file_name, ['.mp4', '.mov']))
            <video controls>
                <source src="{{ asset($attachment->file_path) }}" type="video/mp4">
            </video>
        @else
            <img src="{{ asset($attachment->file_path) }}" alt="Attachment Preview">
        @endif
    </div>
</div>
@include('partials.footer') 