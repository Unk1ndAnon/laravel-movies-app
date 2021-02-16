@extends('layouts.main')

@section('content')
    {{-- Movie Info --}}
    <div class="movie-info border-b border-gray-800">
        <div class="container mx-auto px-4 py-16 flex flex-col md:flex-row">
            <img src="https://image.tmdb.org/t/p/w500{{ $movie['poster_path'] }}" alt={{ $movie['title'] }}
                class="w-64 md:w-96 mx-auto">
            <div class="md:ml-24 mt-12 md:mt-0">
                <h2 class="text-4xl font-semibold">{{ $movie['title'] }}</h2>
                <div class="flex flex-wrap items-center text-gray-300 text-sm mt-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        class="fill-current text-yellow-600 w-4">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                    </svg>
                    <span class="ml-1">{{ $movie['vote_average'] * 10 . '%' }}</span>
                    <span class="mx-1">|</span>
                    <span>{{ \Carbon\Carbon::parse($movie['release_date'])->format('M d, Y') }}</span>
                    <span class="mx-1">|</span>
                    <span>
                        @foreach ($movie['genres'] as $genre)
                            {{ $genre['name'] }}@if (!$loop->last),@endif
                        @endforeach
                    </span>
                </div>
                <p class="text-gray-300 mt-8">
                    {{ $movie['overview'] }}
                </p>

                {{-- Movie Crew --}}
                <div class="mt-12">
                    <h4 class="text-white font-semibold">Feature Crews</h4>
                    <div class="flex mt-4">
                        @foreach ($movie['credits']['crew'] as $crew)
                            @if ($loop->index < 3)
                                <div class="mr-8">
                                    <div>{{ $crew['name'] }}</div>
                                    <div class="text-sm text-gray-400">{{ $crew['job'] }}</div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                {{-- End Movie Crew --}}

                <div x-data="{isOpen: false}">
                    {{-- Movie Trailer --}}
                    @if (count($movie['videos']['results']) > 0)
                        <div class="mt-12">
                            <button @click="isOpen = true" {{-- href="https://youtube.com/watch?v={{ $movie['videos']['results'][0]['key'] }}" --}} {{-- target=_blank --}}
                                class="inline-flex items-center bg-yellow-600 hover:bg-yellow-700 transition ease-in-out duration-150 text-gray-900 rounded font-semibold px-5 py-4">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" class="w-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="ml-2">Play Trailer</span>
                            </button>
                        </div>
                    @endif
                    {{-- End Movie Trailer --}}

                    {{-- Modal Trailer --}}
                    <div style="background-color: rgba(0, 0, 0, .5);"
                        class="fixed top-0 left-0 w-full h-full flex items-center shadow-lg overflow-y-auto"
                        x-show.transition.duration.400ms="isOpen">
                        <div class="container mx-auto lg:px-32 rounded-lg overflow-y-auto">
                            <div class="bg-gray-900 rounded">
                                <div class="flex justify-end pr-4 pt-2">
                                    <button @click="isOpen = false" @keydown.escape.window="isOpen = false"
                                        class="text-3xl leading-none hover:text-gray-300">&times;
                                    </button>
                                </div>
                                <div class="modal-body px-8 py-8">
                                    <div class="responsive-container overflow-hidden relative" style="padding-top: 56.25%">
                                        <iframe class="responsive-iframe absolute top-0 left-0 w-full h-full"
                                            src="https://www.youtube.com/embed/{{ $movie['videos']['results'][0]['key'] }}"
                                            style="border:0;" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- End Modal Trailer --}}
                </div>
            </div>
        </div>
    </div>
    {{-- end Movie Info --}}

    {{-- Movie Cast --}}
    <div class="movie-cast border-b border-gray-800">
        <div class="container mx-auto px-4 py-16">
            <h2 class="text-4xl font-semibold">Cast</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-10">
                @foreach ($movie['credits']['cast'] as $cast)
                    @if (isset($cast['profile_path']))
                        @if ($loop->index < 5)
                            <div class="mt-8">
                                <a href="#">
                                    <img src="https://image.tmdb.org/t/p/w500{{ $cast['profile_path'] }}"
                                        alt={{ $cast['name'] }}
                                        class="hover:opacity-70 transition ease-in-out duration-300">
                                </a>
                                <div class="mt-2">
                                    <a href="#" class="text-lg mt-2 hover:text-gray-300">{{ $cast['name'] }}</a>
                                    <div class="text-gray-400 text-sm">{{ $cast['character'] }}</div>
                                </div>
                            </div>
                        @endif
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    {{-- End Movie Cast --}}

    {{-- Movie Images --}}
    <div class="movie-images border-b border-gray-800">
        <div class="container mx-auto px-4 py-16" x-data="{isOpen: false, image: ''}">
            <h2 class="text-4xl font-semibold">Images</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($movie['images']['backdrops'] as $image)
                    @if ($loop->index < 9)
                        <div class="mt-8">
                            <a href="#"
                                @click.prevent="isOpen = true, image = 'https://image.tmdb.org/t/p/original{{ $image['file_path'] }}'">
                                <img src="https://image.tmdb.org/t/p/w500{{ $image['file_path'] }}"
                                    alt={{ $movie['title'] }}
                                    class="hover:opacity-70 transition ease-in-out duration-300" />
                            </a>
                        </div>
                    @endif
                @endforeach
            </div>

            {{-- Modal Images --}}
            <div style="background-color: rgba(0, 0, 0, .5);" x-show="isOpen"
                class="fixed top-0 left-0 w-full h-full flex items-center shadow-lg overflow-y-auto">
                <div class="container mx-auto lg:px-32 rounded-lg overflow-y-auto">
                    <div class="bg-gray-900 rounded">
                        <div class="flex justify-end pr-4 pt-2">
                            <button @click="isOpen = false" @keydown.escape.window="isOpen = false"
                                class="text-3xl leading-none hover:text-gray-300">&times;
                            </button>
                        </div>
                        <div class="modal-body px-8 py-8">
                            <img :src="image" alt="image">
                        </div>
                    </div>
                </div>
            </div>
            {{-- End Modal Images --}}
        </div>
    </div>
    {{-- End Movie Images --}}


@endsection
