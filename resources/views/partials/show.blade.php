@include('partials.header', ['title' => 'adish HAP | Ticket Attachment'])
<div class="fixed inset-0 bg-black bg-opacity-80 flex justify-center items-center">
    <div class="w-full max-w-6xl px-6 py-10 object-cover shadow">
        @if (Str::endsWith($attachment->file_name, ['.doc', '.docx']))
        <div class="flex flex-row justify-between">
            <p class="text-white text-sm mb-2 ml-1">{{ $attachment->file_name }}</p>
            <a href="{{ asset($attachment->file_path) }}" download="{{ asset($attachment->file_name) }}" class="text-sm font-medium text-blue-300 ml-1">Download</a>
        </div>
        @else
        <p class="text-white text-sm mb-2 ml-1">{{ $attachment->file_name }}</p>
        @endif
        @if (Str::endsWith($attachment->file_name, ['.mp4', '.mov']))
        <video controls>
            <source src="{{ asset($attachment->file_path) }}" type="video/mp4">
        </video>
        @elseif (Str::endsWith($attachment->file_name, '.pdf'))
            <iframe src="{{ asset($attachment->file_path) }}" width="100%" height="650px" style="border: none;"></iframe>
        @elseif (Str::endsWith($attachment->file_name, ['.doc', '.docx']))
        <iframe src="https://docs.google.com/gview?url={{ asset($attachment->file_path) }}&embedded=true" width="100%" height="650px" style="border: none;"></iframe>
        @else
            <img src="{{ asset($attachment->file_path) }}" alt="Attachment Preview">
        @endif
    </div>
</div>
@include('partials.footer') 