<?php

namespace RtTests\OctopusAPITests;

use DateTime;
use District5\Date\Date;
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
        //var_dump($connection->getStandingCharges('E-1R-VAR-22-11-01-K'));exit;
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
                    $this->assertTrue(in_array(
                        $agreement->getRegionCode(),
                        ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'J', 'K', 'L', 'M', 'N', 'P', 'Q', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z']
                    ));

                    $electricityService = $connection->getElectricityService();
                    $standingCharges = $electricityService->getStandingCharges(
                        $agreement->getTariffCode(),
                        Date::modify(Date::nowUtc())->minus()->years(1),
                        Date::nowUtc()
                    );
                    $this->assertNotEmpty($standingCharges);
                    $this->assertIsArray($standingCharges);
                    foreach ($standingCharges as $standingCharge) {
                        $this->assertNotEmpty($standingCharge->getValidFrom());
                        $this->assertInstanceOf(DateTime::class, $standingCharge->getValidFrom());
                        $this->assertIsFloat($standingCharge->getValueExcVat());
                        $this->assertIsFloat($standingCharge->getValueIncVat());
                        $this->assertGreaterThan($standingCharge->getValueExcVat(), $standingCharge->getValueIncVat());
                    }

                    $unitRates = $electricityService->getStandardUnitRates(
                        $agreement->getTariffCode(),
                        Date::modify(Date::nowUtc())->minus()->years(1),
                        Date::nowUtc()
                    );
                    $this->assertNotEmpty($unitRates);
                    $this->assertIsArray($unitRates);
                    foreach ($unitRates as $unitRate) {
                        $this->assertNotEmpty($unitRate->getValidFrom());
                        $this->assertInstanceOf(DateTime::class, $unitRate->getValidFrom());
                        $this->assertIsFloat($unitRate->getValueExcVat());
                        $this->assertIsFloat($unitRate->getValueIncVat());
                        $this->assertGreaterThan($unitRate->getValueExcVat(), $unitRate->getValueIncVat());
                    }
                }
            }
        }
    }
}
