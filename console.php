<?php declare(strict_types=1);

use App\Console\Console;

require_once 'vendor/autoload.php';

$console = new Console($argv);
$console->run();