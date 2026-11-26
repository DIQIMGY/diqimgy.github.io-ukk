<?php

namespace Tests\Feature;

use App\Models\Series;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminSeriesPaginationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_series_pagination_displays_valid_links_on_second_page(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        foreach (range(1, 25) as $i) {
            Series::create([
                'nama_series' => 'Series ' . $i,
                'penulis' => 'Penulis ' . $i,
                'deskripsi' => 'Deskripsi series ' . $i,
                'slug' => 'series-' . $i,
            ]);
        }

        $response = $this->actingAs($admin)->get('/admin/series?page=2');

        $response->assertOk();
        $response->assertSee('Koleksi Series');
        $response->assertSee('href="/admin/series?page=1"', false);
        $response->assertSee('href="/admin/series?page=3"', false);
    }
}
