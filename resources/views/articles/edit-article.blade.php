@include('partials.header', ['title' => 'adish HAP | Individual Article'])
@include('partials.menu')
<div class="flex flex-row gap-x-10 pt-20">
    <div class="flex-none">
      @include('partials.sidebar')
    </div>
    <div class="sm:ml-64 w-full min-h-screen flex flex-col gap-x-5 bg-custom-gray p-5">
        @include('components.messages')
        <div class="w-full bg-white p-5 rounded-lg shadow">
            <div class="flex flex-row justify-between p-2 items-center">
                <div class="flex flex-row items-center gap-x-2">
                    @if($article->user->profile_picture)
                    <img src="{{ asset('storage/' . $article->user->profile_picture) }}" class="w-10 h-10 mb-3 mt-2 rounded-full object-cover" alt="Profile Picture" />
                    @else 
                    <img src="{{ asset('images/user.png') }}" class="w-10 h-10 mb-3 mt-2" alt="Default Profile Picture" />
                    @endif
                    <div class="flex flex-col text-sm">
                        <p class="font-medium">{{$article->user->first_name}} {{$article->user->last_name}}</p>
                        <p>{{$article->user->position}} at {{$article->user->company->name}}</p>
                    </div>
                </div>
                <div class="flex flex-col text-sm">
                    <p>{{$article->user->department->name}}</p>
                    <p>{{$article->created_at->format('F d, Y')}}</p>
                </div>
        </div>
        <hr>
        @auth('user')
        @if($article->user_id == Auth::guard('user')->user()->id || auth('user')->user()->isSuperUser())
        <form action="{{ route('articles.update', ['article' => $article->id]) }}" method="POST">
            @method('PUT')
            @csrf
            <div class="p-5 flex flex-col gap-y-3">
                <div>
                    <label for="title" class="text-sm font-medium">Title:</label>
                    <input type="text" name="title" id="title" class="mt-2 mb-5 w-full border-[1px] border-black p-2 text-sm rounded-sm" placeholder="Describe the subject of the article" required value="{{$article->title}}">
                    @error('title')
                    <p class="text-xs text-red-700 -mt-4">{{$message}}</p>
                    @enderror
                </div>
                <div class="flex flex-col mb-5 h-full">
                    <label for="content" class="text-sm font-medium mb-2">Content:</label>
                    <div id="editor" class="overflow-y-auto">{!! $article->content !!}</div>
                    <textarea name="content" id="content" style="display: none;"></textarea>
                    <textarea name="content_text" id="content_text" style="display: none;"></textarea>
                    @error('content_text')
                    <p class="text-xs text-red-700 mt-1">{{$message}}</p>
                    @enderror
                  </div>
            </div>
            <div class="flex justify-end mr-5">
                <button type="submit" class="w-24 p-2 bg-custom-orange rounded-sm text-white text-sm font-semibold">Update</button>
            </div>
        </form>
        @elseif (auth('user')->user()->isUser() || auth('user')->user()->isCustomer())
        <div class="p-5 flex flex-col gap-y-3">
            <p class="text-xs italic text-gray-700">Last updated on {{$article->updated_at->format('F d, Y')}}</p>
            <p class="font-semibold text-lg">{{$article->title}}</p>
            <div class="ql-editor p-0 text-sm text-justify">{!! $article->content !!}</div>
        </div>
        @endif
        @endauth
        </div>
    </div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
    <script>
      const quill = new Quill('#editor', {
        theme: 'snow',
        modules: {
        toolbar: [
            ['bold', 'italic', 'underline'],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            ['clean'],
            ['image']
        ]
      }});

      function updateContent() {
            var html = quill.root.innerHTML;
            document.getElementById('content').value = html;

            //plain text
            var tempDiv = document.createElement('div');
            tempDiv.innerHTML = html;
            var plainText = tempDiv.textContent || tempDiv.innerText || '';
            document.getElementById('content_text').value = plainText;
        }

        quill.on('text-change', function() {
            updateContent();
        });

        updateContent();

        document.getElementById('editor').addEventListener('input', function () {
            updateContent();
    });
    </script>
@include('partials.footer')