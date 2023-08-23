<?php

namespace App\Tests\PhpUnit;

use App\GameManager;
use App\Interfaces\GameInterface;
use App\Interfaces\GameRepositoryInterface;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class GameManagerTest extends TestCase
{
    private GameManager $gameManager;
    private \PHPUnit\Framework\MockObject\MockObject $gameRepository;


    public function setUp(): void
    {
        parent::setUp();

        $this->gameRepository = $this->createMock(GameRepositoryInterface::class);
        $this->gameManager = new GameManager($this->gameRepository);
    }

    /** @test */
    public function gameCanBeStarted()
    {
        $homeTeam = 'Poland';
        $awayTeam = 'Brazil';

        /** @var GameInterface $game */
        $game = $this->gameManager->startGame($homeTeam, $awayTeam);
        $manager = new ReflectionClass(GameManager::class);

        $this->assertTrue($manager->implementsInterface(GameInterface::class));
        $this->assertSame($homeTeam, $game->getHomeTeamName());
        $this->assertSame($awayTeam, $game->getAwayTeamName());
        $this->assertSame(0, $game->getAwayTeamScore());
        $this->assertSame(0, $game->getHomeTeamScore());
    }

    /**
     * @test
     */
    public function invalidTeamCauseAnExceptionAtStart()
    {
        $this->expectExceptionMessage("The team name can't be empty");
        $homeTeam = '';
        $awayTeam = 'Brazil';

        /** @var GameInterface $game */
        $game = $this->gameManager->startGame($homeTeam, $awayTeam);
    }

    /**
     * @test
     */
    public function invalidTeamCauseAnExceptionAtStart2()
    {
        $this->expectExceptionMessage("The team name can't be empty");
        $homeTeam = 'Poland';
        $awayTeam = '';

        /** @var GameInterface $game */
        $game = $this->gameManager->startGame($homeTeam, $awayTeam);
    }

    /** @test */
    public function correctGameCanBeFinished()
    {
        $homeTeam = 'Poland';
        $awayTeam = 'Brazil';

        /** @var GameInterface $game */
        $game = $this->gameManager->startGame($homeTeam, $awayTeam);
        $gameId = $game->getId();
        $this->gameManager->finishGame($gameId);


        $this->gameRepository->expects(self::once())
            ->method('findGameById')->willReturn([
                new Game()
            ]);

        //assert method getGameById() is called and game->finish()
        $this->gameManager->findGame($gameId);

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
