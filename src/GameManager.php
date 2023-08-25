<?php

namespace App;

use App\Interfaces\GameFactoryInterface;
use App\Interfaces\GameInterface;
use App\Interfaces\GameRepositoryInterface;

class GameManager
{
    public function __construct(private GameRepositoryInterface $repository, private GameFactoryInterface $gameFactory)
    {
    }

    /**
     * @param string $homeTeam
     * @param string $awayTeam
     * @return int
     * @throws \Exception
     */
    public function startGame(string $homeTeam, string $awayTeam): int
    {
        if (empty($homeTeam) || empty($awayTeam)) {
            throw new \Exception("The team name can't be empty");
        }

        if ($homeTeam === $awayTeam) {
            throw new \Exception("The team names can't be the same");
        }

        $game = $this->gameFactory->create($homeTeam, $awayTeam, 0, 0);
        return $this->repository->add($game);
    }

    /**
     * @param int $gameId
     * @return void
     * @throws \Exception
     */
    public function finishGame(int $gameId): bool
    {
        if (empty($gameId)) {
            throw new \Exception("Invalid game ID is provided");
        }

        return $this->repository->finishGame($gameId);
    }
}
