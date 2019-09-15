<?php

namespace App\model\skill;

interface Skill
{
    /**
     * @desc execute the skill
     */
    public function run();

    /**
     * @return bool
     */
    public function isDefence(): bool;

    /**
     * @return bool
     */
    public function isAttack(): bool;
}
