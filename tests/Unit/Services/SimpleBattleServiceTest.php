<?php

namespace Tests\Unit\Services;

use App\Exceptions\CannotDetermineStarterException;
use App\Models\Contender;
use App\Services\BattleConfiguration;
use App\Services\Impl\SimpleBattleService;
use Illuminate\Support\Collection;
use Tests\TestCase;

class SimpleBattleServiceTest extends TestCase
{
    protected SimpleBattleService $service;

    /**
     * @var Collection<Contender>
     */
    protected Collection $contendersA;

    /**
     * @var Collection<Contender>
     */
    protected Collection $contendersB;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new SimpleBattleService(new BattleConfiguration());
    }

    public function getContender($overwrites = [])
    {
        return Contender::create(array_merge([
            'defense' => 5,
            'attack' => 20,
            'health' => 100,
            'speed' => 10,
        ], $overwrites));
    }

    /**
     * @throws CannotDetermineStarterException
     */
    public function test_simple_fight(): void
    {
        $c1 = $this->getContender();
        $c2 = $this->getContender([
            'defense' => 7,
            'attack' => 15,
            'health' => 100,
            'speed' => 8,
        ]);
        $result = $this->service->runFight($c1, $c2);
        $this->assertEquals($result->getWinner(), $c1);
        $this->assertEquals($result->getLoser(), $c2);
    }

    public function test_damage(): void
    {
        $c1 = $this->getContender([
            'attack' => 15,
            'health' => 100,
        ]);
        $c2 = $this->getContender([
            'defense' => 10,
            'health' => 100,
        ]);
        $this->service->performAttack($c1, $c2);
        $this->assertEquals(95, $c2->health);
    }

    public function test_minimum_damage(): void
    {
        $c1 = $this->getContender([
            'attack' => 15,
            'health' => 100,
        ]);
        $c2 = $this->getContender([
            'defense' => 15,
            'health' => 100,
        ]);
        $this->service->performAttack($c1, $c2);
        $this->assertEquals(99, $c2->health);
    }

    public function test_cannot_determine_starter(): void
    {
        $this->expectException(CannotDetermineStarterException::class);
        $this->service->runFight($this->getContender(), $this->getContender());
    }

    /**
     * @throws CannotDetermineStarterException
     */
    public function test_greater_speed_starts_fight(): void {
        $c1 = $this->getContender([
            "speed" => 16
        ]);
        $c2 = $this->getContender([
            "speed" => 15
        ]);
        $this->assertEquals($c1, $this->service->getStarter($c1, $c2));
    }

    /**
     * @throws CannotDetermineStarterException
     */
    public function test_same_speed_greater_attack_starts_fight(): void {
        $c1 = $this->getContender([
            "speed" => 15,
            "attack" => 10,
        ]);
        $c2 = $this->getContender([
            "speed" => 15,
            "attack" => 9,
        ]);
        $this->assertEquals($c1, $this->service->getStarter($c1, $c2));
    }
}
