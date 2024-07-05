<?php

namespace RtTests\OctopusAPITests;

use GuzzleHttp\Exception\GuzzleException;

/**
 * Class OctopusConnectionTest
 * @package RtTests\OctopusAPITests\HelperTests
 */
class OctopusConnectionTest extends TestAbstract
{
    /**
     * @return void
     * @throws GuzzleException
     */
    public function testGettingToken(): void
    {
        $connection = $this->getConnection();
        $token = $connection->getToken();
        $this->assertNotEmpty($token);
        $this->assertIsString($token);
    }

    /**
     * @return void
     * @throws GuzzleException
     */
    public function testGetMeter(): void
    {
        $connection = $this->getConnection();
        $meterDeviceId = $connection->getMeterDeviceId();
        $this->assertNotEmpty($meterDeviceId);
        $this->assertIsString($meterDeviceId);
    }

    /**
     * @return void
     * @throws GuzzleException
     */
    public function testGetLiveConsumption(): void
    {
        $connection = $this->getConnection();
        $consumption = $connection->getLiveConsumption();
        $this->assertIsInt($consumption);
        $this->assertGreaterThan(0, $consumption);
        echo "---\n";
        echo "Live consumption: $consumption\n";
        echo "---\n";
    }
}
