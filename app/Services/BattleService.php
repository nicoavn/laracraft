<?php

namespace App\Services;

use App\Models\Contender;

abstract class BattleService
{
    protected BattleResult $result;

    abstract public function runFight(Contender $contenderA, Contender $contenderB): BattleResult;

    public function getResult(): BattleResult
    {
        return $this->result;
    }
}
