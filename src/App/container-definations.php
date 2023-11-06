<?php

declare(strict_types=1);

use Framework\TemplateEngine;
use App\Config\Paths;

return [
    // Factory function: as it must return an instance
    // we can also write anonyms function instead of arrow fun
    TemplateEngine::class => fn () => new TemplateEngine(Paths::VIEW)
];
