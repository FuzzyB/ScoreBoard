<?php

namespace App;

use App\Interfaces\GameFactoryInterface;
use App\Interfaces\GameInterface;

class GameFactory implements GameFactoryInterface
{

    public function __construct()
    {
    }

    public function create(
        string $homeTeam,
        string $awayTeam,
        int $homeTeamScores,
        int $awayTeamScores,
        int $state = Game::STATE_IN_PROGRESS
    ): Game
    {
        return new Game($homeTeam, $awayTeam, $homeTeamScores, $awayTeamScores, $state);
    }
}
