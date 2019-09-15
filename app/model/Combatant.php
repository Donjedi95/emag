<?php

namespace App\model;

interface Combatant
{
    /**
     * @desc Logic behind an attack
     */
    public function attack(): void;

    /**
     * @desc Logic behind an defence
     * @return bool
     */
    public function defend(): bool;

    /**
     * @param $damage
     */
    public function receiveDamage($damage): void;
}
