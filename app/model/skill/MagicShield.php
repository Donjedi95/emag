<?php

namespace App\model\skill;

use App\controller\Combat;
use App\model\Entity;
use App\utils\Utils;

class MagicShield implements Skill
{
    const SKILL_CHANCE = 0.20;

    /** @var Entity $skillUser */
    private $skillUser;

    /**
     * MagicShield constructor.
     * @param Entity $entity
     */
    public function __construct(Entity $entity)
    {
        $this->skillUser = $entity;
    }

    /**
     * @desc execute the skill
     * @return int
     */
    public function run(): int
    {
        if (self::SKILL_CHANCE > Utils::randomFloat(0, 1)) {
            Combat::log(
                '*"{skill}" was used by {skill_user}* and defended for {defended_damage}.',
                [
                    '{skill}' => Utils::get_class_name(__CLASS__),
                    '{skill_user}' => $this->skillUser->name,
                    '{defended_damage}' => (int)(($this->skillUser->target->strength - $this->skillUser->defence) / 2)
                ]
            );

            return (int)(($this->skillUser->target->strength - $this->skillUser->defence) / 2);
        }

        return 0;
    }

    /**
     * @return bool
     */
    public function isDefence(): bool
    {
        return true;
    }

    /**
     * @return bool
     */
    public function isAttack(): bool
    {
        return false;
    }
}
