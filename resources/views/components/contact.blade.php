@include('partials.header', ['title' => 'adish HAP | Contact'])
@include('partials.nav')
@include('components.messages')
    <div class="mt-10">
    <div class="flex flex-row px-20 py-10">
        <div class="w-1/2 bg-custom-gray flex flex-col justify-center gap-y-3 px-32 py-20 rounded-l-lg">
            <h1 class="font-bold text-3xl text-custom-orange">Let's discuss how adish HAP can benefit you</h1>
            <div class="flex flex-row py-2 gap-x-2 items-center mt-3">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-custom-orange">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                  </svg>
                <p class="text-sm">One flexible tool to share knowledge, manage tickets, and collaborate.</p>                  
            </div>
            <div class="flex flex-row py-2 gap-x-2 items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-custom-orange">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                  </svg>
                <p class="text-sm">Added features for secure management of user access and security.</p>                  
            </div>
            <div class="flex flex-row py-2 gap-x-2 items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-custom-orange">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                  </svg>
                <p class="text-sm">Dedicated support for your tickets and guidance throughout the process.</p>                  
            </div>
        </div>
        <div class="w-1/2 px-10">
            <p class="text-lg font-medium">Get in Touch</p>
            <p class="text-sm mb-5 text-gray-500">Whether you have a question about features, accounts, need a demo, or anything else, our team is ready to answer all your questions. </p>
            <form method="POST" action="{{ url("/submit/contact") }}">
            @csrf   
                    <label for="name" class="text-sm font-medium">Name</label>
                    <input type="text" name="name" id="name" placeholder="Enter your full name" class="mt-2 mb-5 w-full border-[1px] border-black p-1.5 text-sm rounded-sm" required value="{{old('name')}}" 
                    pattern="[A-Za-z\s-]+"
                    title="The input type accepts letters, hypen, and spaces only." >
                    @error('name')
                    <p class="text-xs text-red-700 -mt-4">{{$message}}</p> 
                     @enderror
                    <label for="email" class="text-sm font-medium">Email</label>
                    <input type="email" name="email" id="email" placeholder="Enter your email address" class="mt-2 mb-5 w-full border-[1px] border-black p-1.5 text-sm rounded-sm" required value="{{old('email')}}" >
                    @error('email')
                    <p class="text-xs text-red-700 -mt-4">{{$message}}</p> 
                     @enderror
                    <label for="message" class="text-sm font-medium">Message</label>
                    <textarea id="message" name="message" rows="4" cols="50" class="mt-2 mb-5 w-full border-[1px] border-black p-1.5 text-sm rounded-sm" placeholder="What can we help with?" required>{{old('message')}}</textarea>
                    @error('message')
                    <p class="text-xs text-red-700 -mt-6 mb-2">{{$message}}</p> 
                     @enderror
                    <button type="submit" class="w-full p-2 bg-custom-orange rounded-sm text-white text-sm font-semibold hover:bg-orange-500">Send Message</button>
            </form>
        </div>
    </div>
</div>
<script>
      document.addEventListener('DOMContentLoaded', function() {
          function sanitizeInput(event) {
              event.target.value = event.target.value.replace(/[^A-Za-z\s-]/g, '');
          }
      
          const inputs = [
              document.getElementById('name')
          ];
      
          inputs.forEach(input => {
              input.addEventListener('input', sanitizeInput);
          });
        });
</script>
@include('partials.footer')