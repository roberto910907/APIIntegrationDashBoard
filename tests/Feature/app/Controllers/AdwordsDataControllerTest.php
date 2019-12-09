<?php

namespace Tests\Feature\app\Http\Controllers;

use App\Models\Adwords\AdwordsData;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdwordsDataControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testListAdwordsData(): void
    {
        factory(AdwordsData::class, 3)->create([
            'client_adwords_id' => 178291,
            'creative_id' => 67251,
            'ad_group_id' => 98152,
        ]);

        $response = $this->get(route('list_adwords_data', ['clientAdwordsId' => 178291]));
        $response->assertStatus(200);
        $response->assertJsonCount(3);
        $response->assertJsonFragment([
            'client_adwords_id' => 178291,
            'creative_id' => 67251,
            'ad_group_id' => 98152,
        ]);
    }
}
