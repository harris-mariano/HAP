<div class="w-full bg-white p-5 rounded-lg shadow">
  <div class="flex flex-col gap-y-3">
      <p class="text-sm font-semibold">Knowledge Base</p>
      <div class="relative flex items-center">
          <input type="text" id="searchInput" placeholder="Type a keyword here" class="bg-gray-100 p-2 pr-10 text-sm rounded-sm w-full">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="absolute right-3 h-5 w-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
          </svg>
      </div>
  </div>
  <table id="articlesTable" class="border-collapse w-full mt-5">
    <tbody>
        @foreach($articles as $article)
        <tr class="text-sm">
            <td class="py-2 px-4 border-b border-gray-300">{{ $article->title }}</td>
            <td class="py-2 px-4 border-b border-gray-300 text-right">
                <a href="#" class="font-medium text-in-progress">View</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="mt-5">
  {{ $articles->links() }}
</div>
</div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchInput');
        const table = document.getElementById('articlesTable').getElementsByTagName('tbody')[0];
        const noResult = document.getElementById('noResult');

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