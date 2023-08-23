<?php

namespace App;

use App\Interfaces\GameRepositoryInterface;

class GameManager
{
    public function __construct(private GameRepositoryInterface $repository)
    {
    }

    public function startGame(string $homeTeam, string $awayTeam)
    {

    }
}
