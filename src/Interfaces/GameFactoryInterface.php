<?php

namespace App\Interfaces;

interface GameFactoryInterface
{
    public function create(): GameInterface;
}
