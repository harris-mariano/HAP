@include('partials.header', ['title' => 'adish HAP | All Articles'])
@include('partials.menu')
<div class="flex flex-row gap-x-10 pt-20">
    <div class="flex-none">
      @include('partials.sidebar')
    </div>
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
              <p class="text-xs text-red-700 -mt-4">{{$message}}</p>
              @enderror
            </div>
            <div class="flex flex-col px-2 mb-5 h-64">
              <label for="content" class="text-sm font-medium mb-2">Content:</label>
              <div id="editor" class="overflow-y-auto">{!! old('content') !!}</div>
              <textarea name="content" id="content" style="display: none;"></textarea>
              <textarea name="content_text" id="content_text" style="display: none;"></textarea>
              @error('content_text')
              <p class="text-xs text-red-700 mt-1">{{$message}}</p>
              @enderror
            </div>
            <div class="flex flex row gap-x-2 justify-end mr-2">
              <button id="cancelButton" class="w-24 p-2 mt-5 border border-custom-orange rounded-sm text-sm font-semibold">Cancel</button>
              <button type="submit" class="w-24 p-2 mt-5 bg-custom-orange rounded-sm text-white text-sm font-semibold">Publish</button>
          </div>
        </form>
      </div>
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
      },
        placeholder: 'Describe the necessary actions needed to be performed by the user',
      });

      quill.on('text-change', function() {
        var html = quill.root.innerHTML;
        document.getElementById('content').value = html;

        //plain text
        var tempDiv = document.createElement('div');
        tempDiv.innerHTML = html;
        var plainText = tempDiv.textContent || tempDiv.innerText || '';
        document.getElementById('content_text').value = plainText;
    });
    </script>
    <script>
      var cancelButton = document.getElementById("cancelButton");
      cancelButton.addEventListener("click", function(){
      var clearElements = ["title", "content"];
          clearElements.forEach(function(elementId) {
          document.getElementById(elementId).value = "";
          quill.setContents([]);
      });
      });
  </script>
@include('partials.footer')