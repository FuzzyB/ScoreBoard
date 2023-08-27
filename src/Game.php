<?php

namespace App;

use App\Interfaces\GameInterface;

class Game implements GameInterface
{

    private ?int $id = null;
    const STATE_IN_PROGRESS = 0;
    const STATE_FINISHED = 1;
    /**
     * @param string $homeTeam
     * @param string $awayTeam
     * @param int $homeTeamScores
     * @param int $awayTeamScores
     */
    public function __construct(
        private string $homeTeamName,
        private string $awayTeamName,
        private int $homeTeamScores,
        private int $awayTeamScores,
        private int $state = self::STATE_IN_PROGRESS
    ) {
        $this->validate();
    }

    public function getHomeTeamName(): string
    {
        return $this->homeTeamName;
    }

    public function getAwayTeamName(): string
    {
        return $this->awayTeamName;
    }

    public function getAwayTeamScore(): int
    {
        return $this->awayTeamScores;
    }

    public function getHomeTeamScore(): int
    {
        return $this->homeTeamScores;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isFinished(): bool
    {
        return (bool)$this->state;
    }

    /**
     * @return void
     * @throws \Exception
     */
    private function validate()
    {
        if (empty($this->homeTeamName) || empty($this->awayTeamName)) {
            throw new \Exception("Team name can't be empty");
        }

        if ($this->homeTeamScores < 0 || $this->awayTeamScores < 0 ) {
            throw new \Exception("Score must be positive");
        }

        if (!in_array($this->state, [self::STATE_IN_PROGRESS, self::STATE_FINISHED])) {
            throw new \Exception("Provided status is incorrect");
        }
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function setHomeTeamScore(int $score): void
    {
        if ($score < 0) {
            throw new \Exception("Score must be positive");
        }

        $this->homeTeamScores = $score;
    }

    public function setAwayTeamScore(int $score): void
    {
        if ($score < 0) {
            throw new \Exception("Score must be positive");
        }

        $this->awayTeamScores = $score;
    }

    public function setHomeTeamName(string $name): void
    {
        if (empty($name)) {
            throw new \Exception("Name can't be empty");
        }

        $this->homeTeamName = $name;
    }

    public function setAwayTeamName(string $name): void
    {
        if (empty($name)) {
            throw new \Exception("Name can't be empty");
        }

        $this->awayTeamName = $name;
    }
}
