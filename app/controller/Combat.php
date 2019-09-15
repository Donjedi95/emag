<?php

namespace App\controller;

use App\model\Entity;
use App\utils\GameOver;

class Combat
{
    protected $turn;
    const MAX_TURNS = 20;

    /** @var Entity $attacker */
    private $attacker;
    /** @var Entity $defender */
    private $defender;

    /**
     * Combat constructor.
     * @param Entity $player
     * @param Entity $enemy
     */
    public function __construct(Entity $player, Entity $enemy)
    {
        $this->turn = 1;
        $player->target = $enemy;
        $enemy->target = $player;
        $this->firstAttacker($player, $enemy);
    }

    /**
     * @param Entity $entityOne
     * @param Entity $entityTwo
     * @desc Chooses who is the one who starts the battle
     */
    private function firstAttacker(Entity $entityOne, Entity $entityTwo): void
    {
        if ($entityOne->speed > $entityTwo->speed) {
            $this->attacker = $entityOne;
            $this->defender = $entityTwo;
        } else if ($entityOne->speed < $entityTwo->speed) {
            $this->attacker = $entityTwo;
            $this->defender = $entityOne;
        } else if ($entityOne->luck > $entityTwo) {
            $this->attacker = $entityOne;
            $this->defender = $entityTwo;
        } else {
            $this->attacker = $entityTwo;
            $this->defender = $entityOne;
        }
    }

    /**
     * @desc battle loop
     */
    public function battle(): void
    {
        while($this->attacker->health > 0 && $this->defender->health > 0 && $this->turn <= self::MAX_TURNS) {
            echo ' |ROUND ' . $this->turn . '|: '  . PHP_EOL;
            echo $this->attacker->name . '[HP: ' . $this->attacker->health . ']' . PHP_EOL;
            echo $this->defender->name . '[HP: ' . $this->defender->health . ']' . PHP_EOL;
            $this->attacker->attack();
            $this->defender->attack();
            $this->turn++;
            echo PHP_EOL;
        }

        if ($this->turn > self::MAX_TURNS) {
            new GameOver();
        }
    }

    /**
     * @param $string
     * @param $params
     * @desc helper function to log details based on strtr() function
     */
    public static function log($string, $params): void
    {
        echo strtr($string,$params);
        echo PHP_EOL;
    }
}
