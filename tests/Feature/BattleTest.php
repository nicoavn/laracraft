<?php

namespace Tests\Feature;

use App\Models\Contender;
use Tests\TestCase;

class BattleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_battle_successful_response(): void
    {
        $c1 = Contender::factory()->make();
        $c2 = Contender::factory()->make([
            'health' => 100,
            'defense' => 5,
            'attack' => 5,
            'speed' => 20,
        ]);
        $c1->save();
        $c2->save();
        $c1Id = $c1->id;
        $c2Id = $c2->id;
        $response = $this->get("/api/battles/fight/$c1Id/$c2Id");
        $response->assertStatus(200);
        $response->assertJson([
            'winner' => [
                'id' => $c1->id,
            ],
            'loser' => [
                'id' => $c2->id,
            ],
        ]);
    }
}
