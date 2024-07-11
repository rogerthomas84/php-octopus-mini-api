<?php

namespace Rt\OctopusAPI\Services;

use DateTime;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Rt\OctopusAPI\Dto\AccountDto;
use Rt\OctopusAPI\Dto\ElectricityUnitRateDto;
use Rt\OctopusAPI\Dto\StandingChargeDto;
use Rt\OctopusAPI\OctopusApiSingleton;
use Rt\OctopusAPI\OctopusGraphQL;

/**
 * @class ElectricityService
 * @package Rt\OctopusAPI\Services
 */
class ElectricityService
{
    /**
     * @var OctopusApiSingleton
     */
    private OctopusApiSingleton $api;

    /**
     * ElectricityService constructor.
     */
    public function __construct(OctopusApiSingleton $api)
    {
        $this->api = $api;
    }

    /**
     * @param DateTime $startDate
     * @param DateTime $endDate
     * @param int $pageSize
     * @param string $orderBy
     * @return array[array]
     * @throws GuzzleException
     */
    public function getHalfHourReadings(DateTime $startDate, DateTime $endDate, int $pageSize = 25000, string $orderBy = '-period'): array
    {
        $url = 'https://api.octopus.energy/v1/electricity-meter-points/' . $this->api->getMpan() . '/meters/' . $this->api->getSerialNumber() . '/consumption/';

        $client = new Client();
        $response = $client->get(
            $url,
            [
                'auth' => [$this->api->getApiKey(), ''],
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'query' => [
                    'period_from' => $startDate->format('Y-m-d\TH:i:s\Z'),
                    'period_to' => $endDate->format('Y-m-d\TH:i:s\Z'),
                    'page_size' => $pageSize,
                    'order_by' => $orderBy
                ],
            ]
        );

        $decoded = json_decode($response->getBody()->getContents(), true);
        return $decoded['results'];
    }

    /**
     * @param string $tariffCode
     * @param DateTime|null $dateFrom
     * @param DateTime|null $dateTo
     * @param int $pageSize
     * @return StandingChargeDto[]
     * @throws GuzzleException
     * @throws Exception
     * @example OctopusApiSingleton::getInstance()->getElectricityService()->getStandingCharges(
     *      OctopusApiSingleton::getInstance()->getAccount()->getProperties()[0]->getElectricityMeterPoints()[0]->getAgreements()[0]->getTariffCode(),
     *      new DateTime('2023-01-01T01:29Z'),
     *      new DateTime('2023-07-31T01:29Z'),
     *      10
     * );
     */
    public function getStandingCharges(string $tariffCode, DateTime|null $dateFrom = null, DateTime|null $dateTo = null, int $pageSize = 25000): array
    {
        $productCode = substr($tariffCode, 5, -2);
        $url = sprintf(
            'https://api.octopus.energy/v1/products/%s/electricity-tariffs/%s/standing-charges/',
            $productCode,
            $tariffCode
        );
        $query = [
            'page_size' => $pageSize,
        ];
        if (null !== $dateFrom) {
            $query['period_from'] = $dateFrom->format('Y-m-d\TH:i:s\Z');
        }
        if (null !== $dateTo) {
            $query['period_to'] = $dateTo->format('Y-m-d\TH:i:s\Z');
        }

        $client = new Client();
        $response = $client->get(
            $url,
            [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'query' => $query,
            ]
        );

        $decoded = json_decode($response->getBody()->getContents(), true);
        $results = $decoded['results'];
        $standingCharges = [];
        foreach ($results as $result) {
            $standingCharges[] = StandingChargeDto::inflate($result);
        }

        return $standingCharges;
    }

    /**
     * @param string $tariffCode
     * @param DateTime|null $dateFrom
     * @param DateTime|null $dateTo
     * @param int $pageSize
     * @return ElectricityUnitRateDto[]
     * @throws GuzzleException
     * @throws Exception
     * @example OctopusApiSingleton::getInstance()->getElectricityService()->getStandardUnitRates(
     *      OctopusApiSingleton::getInstance()->getAccount()->getProperties()[0]->getElectricityMeterPoints()[0]->getAgreements()[0]->getTariffCode(),
     *      new DateTime('2023-01-01T01:29Z'),
     *      new DateTime('2023-07-31T01:29Z'),
     *      10
     * );
     */
    public function getStandardUnitRates(string $tariffCode, DateTime|null $dateFrom = null, DateTime|null $dateTo = null, int $pageSize = 25000): array
    {
        $productCode = substr($tariffCode, 5, -2);
        $url = sprintf(
            'https://api.octopus.energy/v1/products/%s/electricity-tariffs/%s/standard-unit-rates/',
            $productCode,
            $tariffCode
        );
        $query = [
            'page_size' => $pageSize,
        ];
        if (null !== $dateFrom) {
            $query['period_from'] = $dateFrom->format('Y-m-d\TH:i:s\Z');
        }
        if (null !== $dateTo) {
            $query['period_to'] = $dateTo->format('Y-m-d\TH:i:s\Z');
        }

        $client = new Client();
        $response = $client->get(
            $url,
            [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'query' => $query,
            ]
        );

        $decoded = json_decode($response->getBody()->getContents(), true);
        $results = $decoded['results'];
        $unitRates = [];
        foreach ($results as $result) {
            $unitRates[] = ElectricityUnitRateDto::inflate($result);
        }

        return $unitRates;
    }
}
