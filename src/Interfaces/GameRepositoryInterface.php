<?php

namespace App\Interfaces;

interface GameRepositoryInterface
{
    public function add(GameInterface $game): ?GameInterface;

    public function finishGame(int $gameId): bool;

    public function findById(int $gameId): ?GameInterface;

    public function update(int $gameId, int $homeTeamScore, int $awayTeamScore): bool;

    public function getAllGames(): array;
}
