<?php

namespace App\Interfaces;

interface GameInterface
{
    public function getHomeTeamName(): string;

    public function getAwayTeamName(): string;

    public function getAwayTeamScore(): int;

    public function getHomeTeamScore(): int;

    public function getId(): int;
}
