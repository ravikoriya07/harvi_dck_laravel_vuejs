<?php

declare(strict_types=1);

/**
 * Root front controller.
 *
 * Allows domain document root to point to the project root while still
 * bootstrapping Laravel from the public entrypoint.
 */
require __DIR__ . '/public/index.php';
