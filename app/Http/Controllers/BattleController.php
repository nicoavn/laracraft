<?php

namespace App\Http\Controllers;

use App\Models\Contender;
use App\Services\BattleService;
use Illuminate\Http\JsonResponse;

class BattleController extends Controller
{
    private BattleService $battleService;

    public function __construct(BattleService $service)
    {
        $this->battleService = $service;
    }

    public function fight(int $contenderAId, int $contenderBId): JsonResponse
    {
        $contenderA = Contender::findOrFail($contenderAId);
        $contenderB = Contender::findOrFail($contenderBId);
        $result = $this->battleService->runFight($contenderA, $contenderB);

        return response()->json([
            'winner' => $result->getWinner(),
            'loser' => $result->getLoser(),
        ]);
    }

    public function list()
    {

    }
}
