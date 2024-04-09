<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class getCustomerTest extends TestCase
{
    private $db;
    protected function setUp(): void
    {
        parent::setUp();
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function testGetCustomerwithID(): void
    {
        $customer = new Customer($this->db);
        $customer->CID = 503;

        $customer->getCustomer();

        // $this->assertSame(true, $state);
        $this->assertIsString($customer->Firstname);
    }
}
