<?php

namespace RtTests\OctopusAPITests;

use Rt\OctopusAPI\OctopusApiSingleton;
use Rt\OctopusAPI\OctopusGraphQL;
use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Framework\TestCase;

/**
 * Class TestAbstract
 * @package RtTests\OctopusAPITests
 */
class TestAbstract extends TestCase
{
    /**
     * @var OctopusGraphQL|null
     */
    private OctopusGraphQL|null $connection = null;

    /**
     * @var OctopusApiSingleton|null
     */
    private OctopusApiSingleton|null $api = null;

    /**
     * @return string
     */
    protected function getEmail(): string
    {
        return getenv('OCTOPUS_EMAIL');
    }

    /**
     * @return string
     */
    protected function getPassword(): string
    {
        return getenv('OCTOPUS_PASSWORD');
    }

    /**
     * @return string
     */
    protected function getAccountNumber(): string
    {
        return getenv('OCTOPUS_ACCOUNT_NUMBER');
    }

    /**
     * @return string
     */
    protected function getApiKey(): string
    {
        return getenv('OCTOPUS_API_KEY');
    }

    /**
     * @return string
     */
    protected function getMpan(): string
    {
        return getenv('OCTOPUS_MPAN');
    }

    /**
     * @return string
     */
    protected function getSerialNumber(): string
    {
        return getenv('OCTOPUS_SERIAL_NUMBER');
    }

    /**
     * @return OctopusGraphQL
     * @throws GuzzleException
     */
    protected function getConnection(): OctopusGraphQL
    {
        if (null !== $this->connection) {
            return $this->connection;
        }

        $this->api = OctopusApiSingleton::getInstance()->setEmail(
            $this->getEmail()
        )->setPassword(
            $this->getPassword()
        )->setAccountNumber(
            $this->getAccountNumber()
        )->setApiKey(
            $this->getApiKey()
        )->setMpan(
            $this->getMpan()
        )->setSerialNumber(
            $this->getSerialNumber()
        );
        $this->connection = $this->api->getOctopusGraphQL();

        return $this->connection;
    }

    /**
     * @return OctopusApiSingleton
     * @throws GuzzleException
     */
    protected function getApi(): OctopusApiSingleton
    {
        if ($this->api === null) {
            $this->getConnection();
        }
        return $this->api;
    }
}
