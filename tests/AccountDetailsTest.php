<?php

namespace RtTests\OctopusAPITests;

use DateTime;
use GuzzleHttp\Exception\GuzzleException;
use Rt\OctopusAPI\Dto\AccountDto;
use Rt\OctopusAPI\Dto\PropertyDto;

/**
 * Class AccountDetailsTest
 * @package RtTests\OctopusAPITests\HelperTests
 */
class AccountDetailsTest extends TestAbstract
{
    /**
     * @return void
     * @throws GuzzleException
     */
    public function testGetMyAccount(): void
    {
        $connection = $this->getApi();
        $account = $connection->getAccount();
        $this->assertInstanceOf(AccountDto::class, $account);
        $this->assertNotEmpty($account->getNumber());
        $this->assertIsString($account->getNumber());
        $this->assertNotEmpty($account->getProperties());
        $this->assertIsArray($account->getProperties());

        $properties = $account->getProperties();

        foreach ($properties as $property) {
            $this->assertInstanceOf(PropertyDto::class, $property);
            $this->assertNotEmpty($property->getElectricityMeterPoints());
            $this->assertIsArray($property->getElectricityMeterPoints());
            $this->assertIsArray($property->getGasMeterPoints());

            $electricityMeterPoints = $property->getElectricityMeterPoints();
            foreach ($electricityMeterPoints as $electricityMeterPoint) {
                $this->assertNotEmpty($electricityMeterPoint->getMpan());
                $this->assertIsString($electricityMeterPoint->getMpan());
                $this->assertNotEmpty($electricityMeterPoint->getProfileClass());
                $this->assertIsInt($electricityMeterPoint->getProfileClass());
                $this->assertNotEmpty($electricityMeterPoint->getConsumptionStandard());
                $this->assertIsInt($electricityMeterPoint->getConsumptionStandard());
                $this->assertNotEmpty($electricityMeterPoint->getMeters());
                $this->assertIsArray($electricityMeterPoint->getMeters());
                $this->assertNotEmpty($electricityMeterPoint->getAgreements());
                $this->assertIsBool($electricityMeterPoint->isExport());

                $meters = $electricityMeterPoint->getMeters();
                foreach ($meters as $meter) {
                    $this->assertNotEmpty($meter->getSerialNumber());
                    $this->assertIsString($meter->getSerialNumber());

                    $registers = $meter->getRegisters();
                    foreach ($registers as $register) {
                        $this->assertNotEmpty($register->getIdentifier());
                        $this->assertIsString($register->getIdentifier());
                        $this->assertNotEmpty($register->getRate());
                        $this->assertIsString($register->getRate());
                        $this->assertIsBool($register->getIsSettlementRegister());
                    }
                }

                $agreements = $electricityMeterPoint->getAgreements();
                foreach ($agreements as $agreement) {
                    $this->assertNotNull($agreement->getValidFrom());
                    $this->assertInstanceOf(DateTime::class, $agreement->getValidFrom());
                    $this->assertIsString($agreement->getTariffCode());
                }
            }
        }
    }
}
