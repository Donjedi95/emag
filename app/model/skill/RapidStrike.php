<?php

namespace App\model\skill;

use App\controller\Combat;
use App\model\Entity;
use App\utils\Utils;

class RapidStrike implements Skill
{
    const SKILL_CHANCE = 0.10;

    /** @var Entity $skillUser */
    private $skillUser;

    /**
     * RapidStrike constructor.
     * @param Entity $entity
     */
    public function __construct(Entity $entity)
    {
        $this->skillUser = $entity;
    }

    /**
     * @desc execute the skill
     */
    public function run()
    {
        if (self::SKILL_CHANCE > Utils::randomFloat(0, 1)) {
            Combat::log(
                '*"{skill}" was used by {skill_user}* and will attack again.',
                [
                    '{skill}' => Utils::get_class_name(__CLASS__),
                    '{skill_user}' => $this->skillUser->name
                ]
            );

            $this->skillUser->attack();
        }
    }

    /**
     * @return bool
     */
    public function isDefence(): bool
    {
        return false;
    }

    /**
     * @return bool
     */
    public function isAttack(): bool
    {
        return true;
    }
}
