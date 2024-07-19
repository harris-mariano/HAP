<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
@if(session()->has('message'))
<div 
x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
class="flex items-center p-4 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 dark:border-green-800" role="alert">
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-green-800">
    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
  </svg>  
    <div>
      <span class="ml-2">{{ session('message') }}</span>
    </div>
  </div>
  @endif 