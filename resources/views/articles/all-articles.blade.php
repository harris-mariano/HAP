@include('partials.header', ['title' => 'adish HAP | All Articles'])
@include('partials.menu')
<div class="flex flex-row gap-x-10 pt-24">
    <div class="flex-none">
      @include('partials.sidebar')
    </div>
    @auth('customer')
    <div class="sm:ml-64 w-full flex flex-row gap-x-5 bg-custom-gray p-5">
      <div class="w-full bg-white p-5 rounded-lg shadow">
        @include('components.knowledge-base')
        </div>
    </div>
    @elseauth('user')
    <div class="sm:ml-64 w-full flex flex-col gap-5 bg-custom-gray p-5">
      @include('components.messages')
    <div class="flex flex-col gap-y-5">
      <div class="w-full bg-white p-5 rounded-lg shadow ">
          <p class="text-sm font-semibold">Publish an Article</p>
          <form action="{{ route('articles.store') }}" method="POST">
            @csrf
          <div class="grid grid-cols-2 gap-x-24 px-2 py-3">
            <div class="flex flex-col">
              <label for="name" class="text-sm font-medium">Name:</label>
              <input type="text" name="name" id="name" class="mt-2 mb-5 w-full bg-[#EAEAEA] p-2 text-sm rounded-sm" value="{{Auth::guard('user')->user()->first_name}} {{Auth::guard('user')->user()->last_name}} " readonly>
            </div>
            <div class="flex flex-col">
              <label for="date" class="text-sm font-medium">Date Published:</label>
              <input type="text" name="date" id="date" class="mt-2 mb-5 w-full bg-[#EAEAEA] p-2 text-sm rounded-sm" value="{{ \Carbon\Carbon::now()->format('F d, Y') }}" readonly>
            </div>
            </div>
            <div class="flex flex-col px-2 mb-5">
              <label for="title" class="text-sm font-medium">Title:</label>
              <input type="text" name="title" id="title" class="mt-2 mb-5 w-full border-[1px] border-black p-2 text-sm rounded-sm" placeholder="Describe the subject of the article" required value="{{old('title')}}">
              @error('title')
              <p class="text-xs text-red-700 mt-2">{{$message}}</p>
              @enderror
            </div>
            <div class="flex flex-col px-2 mb-5 h-64">
              <label for="content" class="text-sm font-medium mb-2">Content:</label>
              <div id="editor" class="overflow-y-auto"></div>
              <textarea name="content" id="content" style="display: none;"></textarea>
              @error('content')
              <p class="text-xs text-red-700 mt-2">{{$message}}</p>
              @enderror
            </div>
            <div class="flex flex row gap-x-5">
              <a id="cancelButton" href="#" class="w-full p-2 mt-5 text-sm text-right">Cancel</a>
              <button type="submit" class="w-32 p-2 mt-5 bg-custom-orange rounded-sm text-white text-sm font-semibold">Publish Article</button>
          </div>
        </form>
      </div>
      <div class="w-full bg-white p-5 rounded-lg shadow ">
        @if($userArticles->count() > 0)
        @include('components.user-articles')
        @else 
        <p class="text-sm font-semibold">Published Articles</p>
        <label for="attachments" class="flex flex-col items-center justify-center w-full h-30  rounded-lg cursor-pointer mt-2">
          <div class="flex flex-col items-center justify-center pt-5 pb-6">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
            </svg>                      
              <p class="mt-1 text-sm font-medium">No published articles yet</p>
          </div>
      </label>
        @endif
      </div>
      <div class="w-full bg-white p-5 rounded-lg shadow ">
          @include('components.knowledge-base')
      </div>
    </div>
  </div>
    @endauth
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
    <script>
      const quill = new Quill('#editor', {
        theme: 'snow',
        modules: {
        toolbar: [
            ['bold', 'italic', 'underline'],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            ['clean']
        ]
      },
        placeholder: 'Describe the necessary actions needed to be performed by the user',
      });

      quill.on('text-change', function() {
        var html = quill.root.innerHTML;
        document.getElementById('content').value = html;
    });
    </script>
    <script>
      var cancelButton = document.getElementById("cancelButton");
      cancelButton.addEventListener("click", function(){
      var clearElements = ["title", "content"];
          clearElements.forEach(function(elementId) {
          document.getElementById(elementId).value = "";
      });
      });
  </script>
@include('partials.footer')