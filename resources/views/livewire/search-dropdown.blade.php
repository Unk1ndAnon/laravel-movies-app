<div class="relative my-3 md:mt-0" x-data="{isOpen: true}" @click.away="isOpen = false">
    <div class="absolute top-1 ml-2 w-4 text-gray-500 mt-4 md:mt-0">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
    </div>
    <input wire:model.debounce.500ms="search" type="text" @focus="isOpen = true" @click="isOpen = true"
        @keydown.escape.window="isOpen = false" @keydown.enter="isOpen = true" @keydown.shift.tab="isOpen = false"
        class="bg-gray-800 text-sm rounded-full w-60 px-4 pl-8 py-1 focus:outline-none mt-3 md:mt-0"
        placeholder="Search">

    <div wire:loading class="spinner top-2/3 right-6 md:top-0 md:right-0 md:mr-5 md:mt-3"></div>

    <div class="z-50 absolute bg-gray-800 rounded w-60 mt-4 text-sm" x-show.transition.duration.300ms="isOpen">
        @if ($searchResults->count() > 0)
            <ul>
                @foreach ($searchResults as $res)
                    <li class="border-b border-gray-700" @if ($loop->last) @keydown.tab="isOpen = false" @endif>
                        <a href={{ route('movies.show', $res['id']) }} class="flex hover:bg-gray-700 px-3 py-3">
                            @if ($res['poster_path'])
                                <img class="w-8" src="https://image.tmdb.org/t/p/w92/{{ $res['poster_path'] }}"
                                    alt="poster" />
                            @else
                                <img class="w-8" src="https://via.placeholder.com/50x75" alt="poster" />
                            @endif
                            <span class="ml-4">{{ $res['title'] }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        @elseif(strlen(trim($search)) >= 2)
            <div class="px-3 py-3 break-words">No results for "{{ $search }}"</div>
        @endif
    </div>
</div>
