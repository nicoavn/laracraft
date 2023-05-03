<?php

namespace App\Services;

use App\Models\Contender;

abstract class BattleService
{
    protected BattleConfiguration $config;

    protected BattleResult $result;

    public function __construct(BattleConfiguration $config)
    {
        $this->config = $config;
    }

    abstract public function runFight(Contender $contenderA, Contender $contenderB): BattleResult;

    public function getResult(): BattleResult
    {
        return $this->result;
    }
}
