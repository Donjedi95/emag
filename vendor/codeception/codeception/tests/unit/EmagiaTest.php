<?php

use App\model\Entity;
use App\utils\GameOver;
use App\utils\Utils;

class EmagiaTest extends \Codeception\Test\Unit
{
    private $playerData;
    private $enemyData;

    /** @var UnitTester */
    protected $tester;
    /** @var Entity $player */
    protected $player;
    /** @var Entity $enemy */
    protected $enemy;

    protected function _before()
    {
        $this->playerData = [
            'name' => 'Orderus',
            'health' => mt_rand(70, 100),
            'strength' => mt_rand(70, 80),
            'defence' => mt_rand(45, 55),
            'speed' => mt_rand(40, 50),
            'luck' => Utils::randomFloat(0.10, 0.30, 2),

            'skills' => [
                'magicShield' => 'MagicShield',
                'rapidStrike' => 'RapidStrike'
            ]
        ];

        $this->enemyData = [
            'name' => 'Wild Beast',
            'health' => mt_rand(60, 90),
            'strength' => mt_rand(60, 90),
            'defence' => mt_rand(40, 60),
            'speed' => mt_rand(40, 60),
            'luck' => Utils::randomFloat(0.25, 0.40, 2),

            'skills' => []
        ];

        try {
            $this->player = new Entity($this->playerData);
        } catch (Exception $e) {}

        try {
            $this->enemy = new Entity($this->enemyData);
        } catch (Exception $e) {}
    }

    protected function _after()
    {
    }

    // tests
    public function testStatsOk()
    {
        if (isset($player)) {
            $this->assertTrue($player->health >= 70);
            $this->assertTrue($player->health <= 100);
            $this->assertTrue($player->strength >= 70);
            $this->assertTrue($player->strength <= 80);
            $this->assertTrue($player->defence >= 45);
            $this->assertTrue($player->defence <= 55);
            $this->assertTrue($player->speed >= 40);
            $this->assertTrue($player->speed <= 50);
            $this->assertTrue($player->luck >= 0.10);
            $this->assertTrue($player->luck <= 0.30);
        }

        if (isset($enemy)) {
            $this->assertTrue($enemy->health >= 60);
            $this->assertTrue($enemy->health <= 90);
            $this->assertTrue($enemy->strength >= 60);
            $this->assertTrue($enemy->strength <= 90);
            $this->assertTrue($enemy->defence >= 40);
            $this->assertTrue($enemy->defence <= 60);
            $this->assertTrue($enemy->speed >= 40);
            $this->assertTrue($enemy->speed <= 60);
            $this->assertTrue($enemy->luck >= 0.25);
            $this->assertTrue($enemy->luck <= 0.40);
        }
    }

    public function testCombatOk()
    {
        $this->player->target = $this->enemy;
        $this->enemy->target = $this->player;

        $turn = 1;
        while($this->player->health > 0 && $this->enemy->health > 0 && $turn <= 20) {
            echo "|Round $turn|: " . PHP_EOL;
            echo $this->player->name . '[' . $this->player->health . ']' . PHP_EOL;
            echo $this->enemy->name . '[' . $this->enemy->health . ']' . PHP_EOL;
            $this->player->attack();
            $this->enemy->attack();
            $this->assertTrue($this->player->health > 0);
            $this->assertTrue($this->enemy->health > 0);
            $this->assertTrue($turn <= 20);
            $turn++;
            echo PHP_EOL;
        }

        if ($this->player->health <= 0 && $this->enemy->health > 0) {
            echo strtr(
                'Game Over. Winner of the battle is {winner_combatant}',
                [
                    '{winner_combatant}' => $this->enemy->name
                ]
            );
        } else if ($this->enemy->health <= 0 && $this->player->health > 0) {
            echo strtr(
                'Game Over. Winner of the battle is {winner_combatant}',
                [
                    '{winner_combatant}' => $this->player->name
                ]
            );
        } else {
            $this->assertTrue(false);
        }
    }
}
