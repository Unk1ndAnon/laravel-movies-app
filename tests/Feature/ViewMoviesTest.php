<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ViewMoviesTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function the_main_page_shows_correct_info()
    {
        Http::fake([
            "https://api.themoviedb.org/3/movie/popular" => Http::response([
                "results" => "foo",
            ], 200)
        ]);

        $response = $this->get(route("movies.index"));
        $response->assertSee("Popular Movies");
        $response->assertSuccessful();
        return $response;
    }
}
