<?php

namespace App\model;

use App\controller\Combat;
use App\utils\GameOver;
use App\utils\Utils;
use App\model\skill\Skill;
use Exception;

class Entity implements Combatant
{
    private $isDead = false;
    public $name;
    public $health;
    public $strength;
    public $defence;
    public $speed;
    public $luck;

    /** @var Entity $target */
    public $target = null;
    /** @var Skill[] $skills */
    public $skills = null;

    /**
     * Entity constructor.
     * @param $data
     * @throws Exception
     */
    public function __construct($data)
    {
        $this->name = $data['name'];
        $this->health = $data['health'];
        $this->strength = $data['strength'];
        $this->defence = $data['defence'];
        $this->speed = $data['speed'];
        $this->luck = $data['luck'];

        if (isset($data['skills'])) {
            foreach ($data['skills'] as $skill) {
                $className = __NAMESPACE__ . '\skill\\' . $skill;
                $this->addSkill($className);
            }
        }
    }

    /**
     * @param $className
     * @throws Exception
     */
    public function addSkill($className): void
    {
        if (class_exists(($className))) {
            $this->skills[] = new $className($this);
        } else {
            $message = 'Skill CLASS file not found for: "{skill}"';
            $messageParams = [
                '{skill}' => $className
            ];

            throw new Exception(strtr($message, $messageParams));
        }
    }

    /**
     * @desc Logic behind an attack
     */
    public function attack(): void
    {
        $this->target->receiveDamage($this->strength - $this->target->defence);
        /** @var Skill $attackerSkill */
        if ($this->skills) {
            foreach ($this->skills as $attackerSkill) {
                if ($attackerSkill->isAttack()) {
                    $attackerSkill->run();
                }
            }
        }
    }

    /**
     * @desc Logic behind an defence
     * @return bool
     */
    public function defend(): bool
    {
        return $this->luck > Utils::randomFloat(0, 1);
    }

    /**
     * @param $damage
     */
    public function receiveDamage($damage): void
    {
        if (! $this->defend()) {
            if ($this->skills) {
                /** @var Skill $defenderSkill */
                foreach ($this->skills as $defenderSkill) {
                    if ($defenderSkill->isDefence()) {
                        $damage -= $defenderSkill->run();
                    }
                }
            }

            $this->health -= $damage;

            Combat::log(
                '{entity_name} did {damage} damage to {second_entity_name}.',
                [
                    '{entity_name}' => $this->target->name,
                    '{damage}' => $damage,
                    '{second_entity_name}' => $this->name
                ]
            );
        } else {
            Combat::log(
                '{entity_name} attacks {second_entity_name}, but {second_entity_name} got lucky and received no damage.',
                [
                    '{entity_name}' => $this->target->name,
                    '{second_entity_name}' => $this->name
                ]
            );
        }

        if ($this->health <= 0) {
            Combat::log(
                '{entity_name} died.' . PHP_EOL,
                [
                    '{entity_name}' => $this->name
                ]
            );

            $this->isDead = true;
            new GameOver($this->target);
        }
    }
}
