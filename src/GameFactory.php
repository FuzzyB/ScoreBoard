<?php

namespace App;

use App\Interfaces\GameInterface;

class GameFactory
{

    public function __construct()
    {
    }

    public function create(string $homeTeam, string $awayTeam, int $homeTeamScores, int $awayTeamScores, int $state): Game
    {
        return new Game($homeTeam, $awayTeam, $homeTeamScores, $awayTeamScores, $state);
    }
}
