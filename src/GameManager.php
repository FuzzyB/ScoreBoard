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

    /**
     * @param int $gameId
     * @param int $pointA
     * @param int $pointB
     * @return void
     * @throws \Exception
     */
    public function updatePoints(int $gameId, int $pointA, int $pointB)
    {
        if ($gameId <= 0) {
            throw new \Exception("Invalid game ID is provided");
        }

        if ($pointB < 0 || $pointA < 0) {
            throw new \Exception( "Points have to be positive");
        }

        $game = $this->repository->findById($gameId);
        if ($game->isFinished()) {
            throw new \Exception("It is impossible to change the game's outcome once it is over.");
        }

        $this->repository->update($gameId, $pointA, $pointB);
    }

    public function getList()
    {
        return $this->repository->getInProgressGames();
    }
}
