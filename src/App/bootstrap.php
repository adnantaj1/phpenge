<?php

declare(strict_types=1);

/** composer autoload dependencies */
require __DIR__ . "/../../vendor/autoload.php";

use function App\Config\registerRoutes;
use Framework\App;

$app = new App();
registerRoutes($app);


return $app;
