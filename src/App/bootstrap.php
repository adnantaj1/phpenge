<?php

declare(strict_types=1);

/** composer autoload dependencies */
require __DIR__ . "/../../vendor/autoload.php";

use function App\Config\{registerRoutes, registerMiddleware};
use App\Config\Paths;
use Framework\App;

$app = new App(Paths::SOURCE . "App/container-definations.php");
registerRoutes($app);
registerMiddleware($app);


return $app;
