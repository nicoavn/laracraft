<?php

namespace App\Services\Impl;

use App\Exceptions\CannotDetermineStarterException;
use App\Models\Contender;
use App\Services\BattleResult;
use App\Services\BattleService;

class SimpleBattleService extends BattleService
{
    /**
     * @throws CannotDetermineStarterException
     */
    public function runFight(Contender $contenderA, Contender $contenderB): BattleResult
    {
        $attacking = $this->getStarter($contenderA, $contenderB);

        do {
            if ($contenderA === $attacking) {
                $this->performAttack($contenderA, $contenderB);
                $attacking = $contenderB;
            } else {
                $this->performAttack($contenderB, $contenderA);
                $attacking = $contenderA;
            }
        } while ($contenderA->health > 0 && $contenderB->health > 0);

        $winner = $contenderA->health > 0 ? $contenderA : $contenderB;
        $loser = $contenderA->health > 0 ? $contenderB : $contenderA;

        return new BattleResult($winner, $loser);
    }

    /**
     * @throws CannotDetermineStarterException
     */
    public function getStarter(Contender $contenderA, Contender $contenderB): Contender
    {
        if ($contenderA->speed > $contenderB->speed) {
            return $contenderA;
        }
        if ($contenderB->speed > $contenderA->speed) {
            return $contenderB;
        }
        if ($contenderA->attack === $contenderB->attack) {
            throw new CannotDetermineStarterException();
        }

        return $contenderA->attack > $contenderB->attack ? $contenderA : $contenderB;
    }

    public function calculateAttackHealthReduction(Contender $contenderA, Contender $contenderB): int
    {
        return max($contenderA->attack - $contenderB->defense, 1);
    }

    public function performAttack(mixed $contenderA, Contender $contenderB): void
    {
        $contenderB->health -= $this->calculateAttackHealthReduction($contenderA, $contenderB);
    }
}
