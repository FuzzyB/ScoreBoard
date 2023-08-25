<?php

namespace App\Tests\PhpUnit;

use App\Game;
use App\GameFactory;
use App\Interfaces\GameInterface;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class GameFactoryTest extends TestCase
{

    /** @test */
    public function createGame()
    {
        $homeTeam = 'Poland';
        $awayTeam = 'Brazil';
        $homeTeamScores = 0;
        $awayTeamScores = 0;
        $state = Game::STATE_IN_PROGRESS;
        $factory = new GameFactory();
        $game = $factory->create($homeTeam, $awayTeam, $homeTeamScores, $awayTeamScores, $state);

        $this->assertInstanceOf(Game::class, $game);
        $this->assertisString($game->getAwayTeamName());
        $this->assertisString($game->getHomeTeamName());
        $this->assertIsInt($game->getHomeTeamScore());
        $this->assertIsInt($game->getAwayTeamScore());

        $gameReflection = new ReflectionClass(get_class($game));
        $this->assertTrue($gameReflection->implementsInterface(GameInterface::class));
    }
}
