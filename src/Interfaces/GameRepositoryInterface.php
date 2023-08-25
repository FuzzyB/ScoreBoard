<?php

namespace App\Interfaces;

interface GameRepositoryInterface
{
    public function add(): GameInterface;

    public function finishGame(int $gameId): bool;

    public function findById(int $gameId): GameInterface;

    public function update(int $gameId, int $pointA, int $pointB): bool;

    public function getInProgressGames(): array;
}
