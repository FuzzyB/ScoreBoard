<?php

namespace App\Interfaces;

interface GameRepositoryInterface
{
    public function add(): int;

    public function finishGame(int $gameId): bool;
}
