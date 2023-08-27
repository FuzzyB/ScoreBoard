<?php

namespace App\Interfaces;

interface GameInterface
{
    public function getHomeTeamName(): string;

    public function getAwayTeamName(): string;

    public function getAwayTeamScore(): int;

    public function getHomeTeamScore(): int;

    public function getId(): ?int;

    public function isFinished(): bool;

    public function setId(?int $id): void;

    public function setHomeTeamScore(int $score): void;

    public function setAwayTeamScore(int $score): void;
}
