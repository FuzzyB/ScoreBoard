<?php

namespace App\Interfaces;

use App\Game;
use App\GameFactory;

interface GameFactoryInterface
{
    public function create(string $homeTeam, string $awayTeam, int $homeTeamPoints, int $awayTeamPoints, int $state = Game::STATE_IN_PROGRESS): GameInterface;
}
