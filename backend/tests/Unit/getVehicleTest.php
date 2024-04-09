<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class getVehicleTest extends TestCase
{
    private $db;
    protected function setUp(): void
    {
        parent::setUp();
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function testGetVehiclewithVID(): void
    {
        $vehicle = new Vehicle($this->db);
        $vehicle->VID = "19UUA65584A863099";

        $vehicle->getVehicle();

        // $this->assertSame(true, $state);
        $this->assertIsString($vehicle->Make);
    }
}
