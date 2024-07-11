<?php

namespace Rt\OctopusAPI;

use DateTime;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Rt\OctopusAPI\Dto\AccountDto;
use Rt\OctopusAPI\Dto\StandingChargeDto;
use Rt\OctopusAPI\Services\ElectricityService;

/**
 * @class OctopusApiSingleton
 * @package Rt\OctopusAPI
 */
class OctopusApiSingleton
{
    /**
     * @var OctopusApiSingleton|null
     */
    protected static OctopusApiSingleton|null $instance = null;

    /**
     * @var string|null
     */
    protected string|null $email = null;

    /**
     * @var string|null
     */
    protected string|null $mpan = null;

    /**
     * @var string|null
     */
    protected string|null $serialNumber = null;

    /**
     * @var string|null
     */
    protected string|null $apiKey = null;

    /**
     * @var string|null
     */
    protected string|null $password = null;

    /**
     * @var string|null
     */
    protected string|null $accountNumber = null;

    /**
     * @return string
     */
    protected OctopusGraphQL|null $graphql = null;

    /**
     * @var ElectricityService|null
     */
    private ElectricityService|null $electricityService = null;

    /**
     * OctopusApiSingleton constructor. Protected to prevent instantiation
     */
    protected function __construct()
    {
    }

    /**
     * @return OctopusApiSingleton
     */
    public static function getInstance(): OctopusApiSingleton
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    /**
     * @param string $email
     * @return OctopusApiSingleton
     */
    public function setEmail(string $email): OctopusApiSingleton
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @param string $password
     * @return OctopusApiSingleton
     */
    public function setPassword(string $password): OctopusApiSingleton
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @param string $accountNumber
     * @return OctopusApiSingleton
     */
    public function setAccountNumber(string $accountNumber): OctopusApiSingleton
    {
        $this->accountNumber = $accountNumber;
        return $this;
    }

    /**
     * @param string $mpan
     * @return OctopusApiSingleton
     */
    public function setMpan(string $mpan): OctopusApiSingleton
    {
        $this->mpan = $mpan;
        return $this;
    }

    /**
     * @param string $serialNumber
     * @return OctopusApiSingleton
     */
    public function setSerialNumber(string $serialNumber): OctopusApiSingleton
    {
        $this->serialNumber = $serialNumber;
        return $this;
    }

    /**
     * @param string $apiKey
     * @return OctopusApiSingleton
     */
    public function setApiKey(string $apiKey): OctopusApiSingleton
    {
        $this->apiKey = $apiKey;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getAccountNumber(): string
    {
        return $this->accountNumber;
    }

    /**
     * @return string
     */
    public function getMpan(): string
    {
        return $this->mpan;
    }

    /**
     * @return string
     */
    public function getSerialNumber(): string
    {
        return $this->serialNumber;
    }

    /**
     * @return string
     */
    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    /**
     * @throws GuzzleException
     */
    public function getOctopusGraphQL(): OctopusGraphQL
    {
        if (null !== $this->graphql) {
            return $this->graphql;
        }
        $this->graphql = new OctopusGraphQL(
            $this->getEmail(),
            $this->getPassword(),
            $this->getAccountNumber()
        );

        return $this->graphql;
    }

    public function getElectricityService(): ElectricityService
    {
        if (null === $this->electricityService) {
            $this->electricityService = new ElectricityService($this);
        }

        return $this->electricityService;
    }

    /**
     * @return AccountDto
     * @throws GuzzleException
     * @throws Exception
     */
    public function getAccount(): AccountDto
    {
        $url = 'https://api.octopus.energy/v1/accounts/' . $this->getAccountNumber(). '/';

        $client = new Client();
        $response = $client->get(
            $url,
            [
                'auth' => [$this->getApiKey(), ''],
                'headers' => [
                    'auth' => [$this->getApiKey(), ''],
                    'Content-Type' => 'application/json',
                ]
            ]
        );

        $decoded = json_decode($response->getBody()->getContents(), true);

        return AccountDto::inflate($decoded);
    }
}
