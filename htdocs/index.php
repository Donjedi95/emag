<?php

use App\controller\Combat;
use App\model\Entity;
use App\utils\Utils;

require_once('../vendor/autoload.php');

$orderusData = [
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

$wildBeastData = [
    'name' => 'Wild Beast',
    'health' => mt_rand(60, 90),
    'strength' => mt_rand(60, 90),
    'defence' => mt_rand(40, 60),
    'speed' => mt_rand(40, 60),
    'luck' => Utils::randomFloat(0.25, 0.40, 2),

    'skills' => []
];

try {
    $player = new Entity($orderusData);
} catch (Exception $e) {}

try {
    $enemy = new Entity($wildBeastData);
} catch (Exception $e) {}

echo "<pre>";
$combat = new Combat($player, $enemy);
$combat->battle();
echo "</pre>";
