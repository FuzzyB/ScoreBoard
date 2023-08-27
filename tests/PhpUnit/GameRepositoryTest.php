<?php

namespace App\Tests\PhpUnit;

use App\Game;
use App\GameRepository;
use PHPUnit\Framework\TestCase;

class GameRepositoryTest extends TestCase
{

    private GameRepository $repository;
    private array $store = [];

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new GameRepository();
    }

    /** @test */
    public function newGameWithIdCantBeAdded()
    {
        $this->expectException(\Exception::class);

        $this->repository = new GameRepository($this->store);
        $game = $this->getGame('Pol', 'Braz', 0, 0, false);
        $game->setId(2);
        $this->repository->add($game);

    }

    /** @test */
    public function gameCanBeAdded()
    {
        $games = [];
        $games[] = $this->getGame('Mexico', 'Canada', 0, 5, false);
        $games[] = $this->getGame('Spain', 'Brazil', 10, 2, false);
        $games[] = $this->getGame('Germany', 'France', 2, 2, false);
        $games[] = $this->getGame('Uruguay', 'Italy', 6, 6, false);



        foreach ($games as $game) {
            $this->repository->add($game);
        }

        $this->assertCount(4, $this->repository->getAllGamesInOrder());
    }

    /** @test */
    public function orderByHigherTotalPoints()
    {
        $games = [];
        $games[] = $this->getGame('Mexico', 'Canada', 0, 5, false);
        $games[] = $this->getGame('Spain', 'Brazil', 10, 2, false);
        $games[] = $this->getGame('Germany', 'France', 2, 2, false);
        $games[] = $this->getGame('Uruguay', 'Italy', 6, 6, false);
        $games[] = $this->getGame('Argentina', 'Australia', 3, 1, false);

        foreach ($games as $game) {
            $this->repository->add($game);
        }

        /** @var Game[] $orderedGames */
        $orderedGames = $this->repository->getAllGamesInOrder();

        $this->assertEquals(3, $orderedGames[0]->getId());
        $this->assertEquals(1, $orderedGames[1]->getId());
        $this->assertEquals(0, $orderedGames[2]->getId());
        $this->assertEquals(4, $orderedGames[3]->getId());
        $this->assertEquals(2, $orderedGames[4]->getId());

    }
    /** @test */
    public function gameIdIncrement()
    {
        $game = $this->getGame('Mexico', 'Canada', 0, 5, false);
        $game2 =  $this->getGame('Uruguay', 'Italy', 6, 6, false);

        $addedGame1 = $this->repository->add($game);
        $addedGame2 = $this->repository->add($game2);

        $this->assertEquals(0, $addedGame1->getId());
        $this->assertEquals(1, $addedGame2->getId());
    }

    /** @test */
    public function findById()
    {
        $games = [];
        $games[0] = $this->getGame('Mexico', 'Canada', 0, 5, false);
        $games[1] = $this->getGame('Spain', 'Brazil', 10, 2, false);
        $games[2] = $this->getGame('Germany', 'France', 2, 2, false);
        $games[3] = $this->getGame('Uruguay', 'Italy', 6, 6, false);

        foreach ($games as $game) {
            $this->repository->add($game);
        }

        $game2 = $this->repository->findById(2);

        $this->repository->finishGame($game2->getId());

        $this->assertEquals(2, $game2->getId());
        $this->assertEquals('Germany', $game2->getHomeTeamName());


    }

    /** @test */
    public function finishGame()
    {
        $game = $this->getGame('Mexico', 'Canada', 0, 5, false);
        $game1 =  $this->getGame('Uruguay', 'Italy', 6, 6, false);

        $this->repository->add($game);
        $this->repository->add($game1);

        $game1 = $this->repository->findById(1);
        $this->repository->finishGame(1);
        $finishedGame = $this->repository->findById(1);

        $this->assertEquals(1, $game1->getId());
        $this->assertEmpty($finishedGame);
    }

    /** @test */
    public function updateScores()
    {
        $game = $this->getGame('Mexico', 'Canada', 0, 5, false);
        $this->repository->add($game);
        $updated = $this->repository->update(0, 2,6);
        $game = $this->repository->findById(0);

        $this->assertTrue($updated);
        $this->assertEquals(2, $game->getHomeTeamScore());
        $this->assertEquals(6, $game->getAwayTeamScore());
    }

    /** @test */
    public function missingEntityToUpdate()
    {
        $game = $this->getGame('Mexico', 'Canada', 0, 5, false);
        $game1 =  $this->getGame('Uruguay', 'Italy', 6, 6, false);

        $this->repository->add($game);
        $this->repository->add($game1);

        $this->repository->finishGame(1);
        $result = $this->repository->update(1, 6, 7);
        $this->assertFalse($result);
    }

    private function getGame($homeTeam, $awayTeam, $scoreHome, $scoreAway, $isFinished, $id = null): Game
    {
      return new Game($homeTeam, $awayTeam, $scoreHome, $scoreAway, $isFinished);
    }

}
