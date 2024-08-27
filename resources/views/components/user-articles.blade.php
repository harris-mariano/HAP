<div class="flex flex-col gap-y-3">
    <div class="flex flex-row items-center">
        <p class="text-sm font-semibold">My Published Articles</p>
      <a href="{{ route('articles.create') }}" class="p-2 rounded-sm ml-auto text-sm font-semibold text-custom-orange mr-1 hover:bg-custom-orange hover:text-white">Create New
    </a> 
    </div>
      <div class="relative flex items-center">
          <input type="text" id="searchInput" placeholder="Type a keyword here" class="bg-gray-100 p-2 pr-10 text-sm rounded-sm w-full">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="absolute right-3 h-5 w-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
          </svg>
      </div>
  </div>
  <table id="userArticlesTable" class="border-collapse w-full mt-5">
    <tbody>
        @foreach($userArticles as $article)
        <tr class="text-sm">
            <td class="py-2 px-4 border-b border-gray-300">
                <a href="{{ route('articles.show', ['article' => $article->id]) }}" class="hover:text-custom-orange">{{$article->title}}</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="mt-5">
  {{ $userArticles->links() }}
</div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchInput');
        const table = document.getElementById('userArticlesTable').getElementsByTagName('tbody')[0];

        searchInput.addEventListener('input', function () {
            const searchQuery = this.value.trim().toLowerCase();

            Array.from(table.rows).forEach(function (row) {
                const title = row.cells[0].textContent.trim().toLowerCase();
                if (title.includes(searchQuery)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });
</script>