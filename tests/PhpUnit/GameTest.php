<?php

namespace App\Tests\PhpUnit;

use App\Game;
use App\GameFactory;
use PHPUnit\Framework\TestCase;

class GameTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
    }


    private function gameDataProvider() {
        return [
            ['Poland', 'Brazil', 0, 0, Game::STATE_IN_PROGRESS],
            ['Spain', 'Brazil', 1, 0, Game::STATE_IN_PROGRESS],
            ['Norway', 'Brazil', 1, 3, Game::STATE_IN_PROGRESS],
        ];
    }

    private function invoidGameDataProvider() {
        return [
            ['Poland', '', 1, 2, Game::STATE_IN_PROGRESS, ""],
            ['', 'Brazil', -1, 2, Game::STATE_IN_PROGRESS, ""],
        ];
    }

    /**
     * @return void
     * @test
     * @dataProvider gameDataProvider
     */
    public function gameObjectIsValid($homeTeam, $awayTeam, $awayTeamScore, $homeTeamScore, $status)
    {
        $homeTeam = 'Poland';
        $awayTeam = 'Brazil';

        $game = new Game($homeTeam, $awayTeam, $awayTeamScore, $homeTeamScore, $status);

        $this->assertSame($homeTeam, $game->getHomeTeamName());
        $this->assertSame($awayTeam, $game->getAwayTeamName());
        $this->assertSame($homeTeamScore, $game->getAwayTeamScore());
        $this->assertSame($awayTeamScore, $game->getHomeTeamScore());
        $this->assertEquals((bool)$status, $game->isFinished());
        $this->assertNotEquals($game->getHomeTeamName(), $game->getAwayTeamName());
    }

    /**
     * @return void
     * @test
     * @dataProvider invoidGameDataProvider
     */
    public function createGameObjectThrowsError($homeTeam, $awayTeam, $awayTeamScore, $homeTeamScore, $status)
    {
        $this->expectException(\Exception::class);
        $game = new Game($homeTeam, $awayTeam, $awayTeamScore, $homeTeamScore, $status);
    }
}
