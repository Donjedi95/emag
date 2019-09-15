<?php

namespace App\utils;
use App\model\Entity;

class GameOver
{
    public function __construct(Entity $winner = null)
    {
        if (! $winner) {
            echo 'Game Over. End of Turns';
        } else {
            echo strtr(
                'Game Over. Winner of the battle is {winner_combatant}',
                [
                    '{winner_combatant}' => $winner->name
                ]
            );
        }

        exit();
    }
}
