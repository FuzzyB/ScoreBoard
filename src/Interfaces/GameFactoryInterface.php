<?php

namespace App\Interfaces;

interface GameFactoryInterface
{
    public function create(string $homeTeam, string $awayTeam, int $homeTeamPoints, int $awayTeamPoints): GameInterface;
}
