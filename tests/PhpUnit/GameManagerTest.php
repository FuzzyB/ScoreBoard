<?php

namespace App\Tests\PhpUnit;

use App\GameManager;
use App\Interfaces\GameFactoryInterface;
use App\Interfaces\GameInterface;
use App\Interfaces\GameRepositoryInterface;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use PHPUnit\Framework\Attributes\DataProvider;

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

        $this->gameRepository = $this->createMock(GameRepositoryInterface::class);
        $this->gameFactory = $this->createMock(GameFactoryInterface::class);

        $this->gameFactory->expects($this->any())->method('create')->willReturn($this->game); //not sure, let it be at the moment
        $this->gameManager = new GameManager($this->gameRepository, $this->gameFactory);
    }


    /** @test */
    public function gameCanBeStarted()
    {
        $homeTeam = 'Poland';
        $awayTeam = 'Brazil';

        $this->gameFactory->expects($this->once())->method('create')->willReturn($this->game);
        $this->gameRepository->expects($this->once())->method('add')->willReturn($this->game->getId());
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



    /** @test */
    public function correctGameCanBeFinished()
    {


        /** @var GameInterface $game */
//        $game = $this->gameManager->startGame($homeTeam, $awayTeam);
//        $gameId = $game->getId();
//        $this->gameManager->finishGame($gameId);
//
//
//        $this->gameRepository->expects(self::once())
//            ->method('update')->willReturn([
//                new Game()
//            ]);

        //assert method getGameById() is called and game->finish()
//        $this->gameManager->finishGame(1);

    }

    //not exists

    //already finished

    /** @test */
    public function gameCanBeUpdated()
    {

    }



    public function gameListIsInOrder()
    {

    }
}
