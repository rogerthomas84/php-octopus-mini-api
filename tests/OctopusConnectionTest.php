<?php

namespace RtTests\OctopusAPITests;

use District5\Date\Date;
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
    public function testGetHalfHourlyReadings(): void
    {
        $connection = $this->getApi();
        $dateFrom = Date::modify(Date::nowUtc())->minus()->hours(48);
        $dateTo = Date::nowUtc();
        $readings = $connection->getHalfHourReadings($dateFrom, $dateTo);
        $this->assertIsArray($readings);
        $this->assertNotEmpty($readings);
        $this->assertIsArray($readings[0]);
        foreach ($readings as $reading) {
            $this->assertIsArray($reading);
            $this->assertArrayHasKey('consumption', $reading);
            $this->assertArrayHasKey('interval_start', $reading);
            $this->assertArrayHasKey('interval_end', $reading);
            $this->assertIsNumeric($reading['consumption']);
        }
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
