<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/app.php';

use Symfony\Component\Console\Application;
use App\Command\RoverNavigationCommand;
use App\Src\RoverNavigation\Platform;
use App\Src\RoverNavigation\Rover;

/**
 * Below an example on how to use the Rover app. This could potentially with a console component (eg. symfony console)
 * 
 */


$platform = new Platform();
$platform->setTopRightCoordinates(5, 5);

$rover1 = new Rover();
$rover1->setRoverPosition(1, 2, 'N', $platform);
$rover1->setMovingInstructions('LMLMLMLMM');
$rover1->navigate($platform);

$rover2 = new Rover();
$rover2->setRoverPosition(3, 3, 'E', $platform);
$rover2->setMovingInstructions('MMRMMRMRRM');
$rover2->navigate($platform);


print_r($rover1->getCurrentPosition());
print_r($rover2->getCurrentPosition());

