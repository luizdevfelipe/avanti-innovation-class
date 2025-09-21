<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;

abstract class BaseTestCase extends TestCase
{
    protected static bool $environmentLoaded = false;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        
        // Load environment variables only once
        if (!self::$environmentLoaded) {
            $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/../../docker');
            $dotenv->load();
            self::$environmentLoaded = true;
        }
    }
}
