<?php

namespace App;

use App\Interfaces\GameInterface;
use App\Interfaces\GameRepositoryInterface;

class GameRepository implements GameRepositoryInterface
{

    public function __construct(private array $store=[])
    {
    }

    /**
     * @param GameInterface $game
     * @return GameInterface|null
     * @throws \Exception
     */
    public function add(GameInterface $game): ?GameInterface
    {
        if ($game->getId() !== null) {

            throw new \Exception("Game with the ID can't be saved");
        }

        $id = $this->getNextAvailableGameId();
        $this->addGame($id, $game);
        $game->setId($id);

        return $game;
    }

    public function finishGame(int $gameId): bool
    {
        unset($this->store['games'][$gameId]);
        return true;
    }

    public function findById(int $gameId): ?GameInterface
    {
        return !empty($this->store['games'][$gameId]) ? $this->store['games'][$gameId] : null;
    }

    public function update(int $gameId, int $homeTeamScore, int $awayTeamScore): bool
    {
        $game = $this->findById($gameId);

        if (empty($game)) {
            return false;
        }

        $game->setHomeTeamScore($homeTeamScore);
        $game->setAwayTeamScore($awayTeamScore);

        return true;
    }

    public function getAllGamesInOrder(): array
    {
        $games = $this->store['games'];
        usort($games, [GameRepository::class, 'compareGames']);

        return $games;
    }

    private function compareGames(GameInterface $a, GameInterface $b): int{
        $sumA = $a->getAwayTeamScore() + $a->getHomeTeamScore();
        $sumB = $b->getAwayTeamScore() + $b->getHomeTeamScore();


        if ($sumA < $sumB ) {
            return 1;
        } else if ($sumA === $sumB && $a->getId() < $b->getId()) {
            return 1;
        } else {
            return -1;
        }
    }

    private function getNextAvailableGameId(): int
    {
        return (empty($this->store['games'])) ? 0 : array_key_last($this->store['games'])+1;
    }

    private function addGame(int $id, GameInterface $game): void
    {
        $this->store['games'][$id] = $game;
    }
}
