@include('partials.header', ['title' => 'adish HAP | All Articles'])
@include('partials.menu')
<div class="flex flex-row gap-x-10 pt-20">
    <div class="flex-none">
      @include('partials.sidebar')
    </div>
    @if(auth('user')->user()->isCustomer())
    <div class="sm:ml-64 w-full min-h-screen flex flex-row gap-x-5 bg-custom-gray p-5">
      <div class="w-full bg-white p-5 rounded-lg shadow">
        @include('components.knowledge-base')
        </div>
    </div>
    @elseif(auth('user')->user()->isUser() || auth('user')->user()->isSuperUser())
    <div class="sm:ml-64 w-full flex flex-col gap-5 bg-custom-gray p-5">
      @include('components.messages')
    <div class="flex flex-col gap-y-5">
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
</div>
    @endif
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