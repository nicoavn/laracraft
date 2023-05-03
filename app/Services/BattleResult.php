<?php

namespace App\Services;

use App\Models\Contender;

class BattleResult
{
    private Contender $winner;

    private Contender $loser;

    public function __construct(Contender $winner, Contender $loser)
    {
        $this->winner = $winner;
        $this->loser = $loser;
    }

    public function getWinner(): Contender
    {
        return $this->winner;
    }

    public function setWinner(Contender $winner): void
    {
        $this->winner = $winner;
    }

    public function getLoser(): Contender
    {
        return $this->loser;
    }

    public function setLoser(Contender $loser): void
    {
        $this->loser = $loser;
    }
}
