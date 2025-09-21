<?php 

namespace App\Tests;

use App\Core\DBConnection;
use App\Tests\BaseTestCase;

class DBConnectionTest extends BaseTestCase
{
    private DBConnection $dbConnection;

    public function setUp(): void
    {
        parent::setUp();
        $this->dbConnection = new DBConnection();
    }

    public function test_connection_initialization(): void
    {
        $this->assertTrue($this->dbConnection->isInitialized());
    }
}