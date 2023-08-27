<?php

namespace App\Tests\PhpUnit;

use App\GameManager;
use App\Interfaces\GameFactoryInterface;
use App\Interfaces\GameInterface;
use App\Interfaces\GameRepositoryInterface;
use PHPUnit\Framework\TestCase;

class GameManagerTest extends TestCase
{
    private GameManager $gameManager;
    private \PHPUnit\Framework\MockObject\MockObject $gameRepository;
    private GameFactoryInterface|\PHPUnit\Framework\MockObject\MockObject $gameFactory;
    private GameInterface|\PHPUnit\Framework\MockObject\MockObject $game;


    public function setUp(): void
    {
        parent::setUp();

        $this->game = $this->createMock(GameInterface::class);
        $this->game->method('getId')->willReturn(1);
        $this->game->method('getHomeTeamName')->willReturn('Poland');
        $this->game->method('getAwayTeamName')->willReturn('Brazil');
        $this->game->method('getAwayTeamScore')->willReturn(0);
        $this->game->method('getHomeTeamScore')->willReturn(0);
        $this->game->method('isFinished')->willReturn(false);


        $this->gameRepository = $this->createMock(GameRepositoryInterface::class);
        $this->gameFactory = $this->createMock(GameFactoryInterface::class);

        $this->gameFactory->expects($this->any())->method('create')->willReturn($this->game); //not sure, let it be at the moment
        $this->gameManager = new GameManager($this->gameRepository, $this->gameFactory);
    }


    /**
     * @return void
     * @throws \Exception
     * @test
     */
    public function gameCanBeStarted()
    {
        $homeTeam = 'Poland';
        $awayTeam = 'Brazil';

        $this->gameFactory->expects($this->once())
            ->method('create')
            ->with($homeTeam, $awayTeam, 0, 0)
            ->willReturn($this->game);
        $this->gameRepository->expects($this->once())->method('add')->willReturn($this->game);
        $game = $this->gameManager->startGame($homeTeam, $awayTeam);
    }

    public function gameNamesForExceptionsDataProvider(): array
    {
        return [
            ['', '', "The team name can't be empty"],
            ['', 'Brazil', "The team name can't be empty"],
            ['Poland', '', "The team name can't be empty"],
            ['Poland', 'Poland', "The team names can't be the same"]
        ];
    }

    /**
     * @dataProvider gameNamesForExceptionsDataProvider
     * @test
     */
    public function invalidTeamCauseAnExceptionAtStart($homeTeam, $awayTeam, $msg)
    {
        $this->expectExceptionMessage($msg);

        /** @var GameInterface $game */
        $this->gameManager->startGame($homeTeam, $awayTeam);
    }

    /**
     * @return void
     * @throws \Exception
     * @test
     */
    public function gameCanBeFinished(): void
    {
        $gameId = 1;
        $this->gameRepository->expects(self::once())
            ->method('finishGame')->with($gameId)
            ->willReturn(true);

        $this->gameManager->finishGame($gameId);
    }

    private function gameIdDataProvider(): array
    {
        return [
            [0, "Invalid game ID is provided"],
        ];
    }

    /**
     * @test
     * @dataProvider gameIdDataProvider
     * @throws \Exception
     */
    public function finishGameHasIncorrectParameter($gameId, $message)
    {
        $this->expectExceptionMessage($message);

        $this->gameManager->finishGame($gameId);

    }

    private function updateGameIdDataProvider(): array
    {
        return [
            [0, 1, 1, "Invalid game ID is provided"],
        ];
    }

    /**
     * @test
     * @dataProvider updateGameIdDataProvider
     * @throws \Exception
     */
    public function gameCanBeUpdated($gameId, $pointA, $pointB, $message)
    {
        $this->expectExceptionMessage($message);

        $this->gameManager->updatePoints($gameId, $pointA, $pointB);
    }

    /**
     * @test
     * @return void
     */
    public function gameUpdateSuccess()
    {
        $gameId = 1;
        $pointB = 2;
        $pointA = 2;
        $this->gameRepository->expects($this->once())
            ->method('findById')
            ->with($gameId)
            ->willReturn($this->game);

        $this->game->expects($this->once())
            ->method('isFinished')
            ->willReturn(false);

        $this->gameRepository->expects($this->once())
            ->method('update')
            ->with($gameId, $pointA, $pointB)
            ->willReturn(true);

        $this->gameManager->updatePoints(1, 2, 2);
    }

    private function pointsExceptionDataProvider(): array
    {
        return [
            [-1, 0, "Points have to be positive"],
            [-1, -2, "Points have to be positive"],
            [2, -2, "Points have to be positive"],
        ];
    }
    /**
     * @param $pointA
     * @param $pointB
     * @return void
     * @throws \Exception
     * @dataProvider pointsExceptionDataProvider
     * @test
     */
    public function gameUpdatePointsHaveToBePositive($pointA, $pointB)
    {
        $this->expectExceptionMessage("Points have to be positive");
        $this->gameManager->updatePoints(1, $pointA, $pointB);

    }

    /**
     * @test
     * @return void
     */
    public function getUpdateFailedByGameStatus()
    {
        $gameId = 1;
        $pointB = 2;
        $pointA = 2;
        $this->expectExceptionMessage("It is impossible to change the game's outcome once it is over.");
        $game = $this->getFinishedGame();
        $this->gameRepository->expects($this->once())
            ->method('findById')
            ->with($gameId)
            ->willReturn($game);

        $game->expects($this->once())
            ->method('isFinished')
            ->willReturn(true);

        $this->gameManager->updatePoints($gameId, $pointA, $pointB);

    }


    /**
     * @return void
     * @test
     */
    public function gameList()
    {
        $this->gameRepository->expects($this->once())->method('getAllGames');

        $games = $this->gameManager->getList();
    }

    /**
     * @return \PHPUnit\Framework\MockObject\Builder\InvocationMocker
     */
    private function getFinishedGame()
    {
        $game = $this->createMock(GameInterface::class);
        $game->method('isFinished')->willReturn(true);
        return $game;

    }
}
