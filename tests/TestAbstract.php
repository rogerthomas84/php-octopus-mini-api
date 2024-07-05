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
     * @return OctopusGraphQL
     * @throws GuzzleException
     */
    protected function getConnection(): OctopusGraphQL
    {
        if (null !== $this->connection) {
            return $this->connection;
        }

        $this->connection = OctopusApiSingleton::getInstance()->setEmail(
            $this->getEmail()
        )->setPassword(
            $this->getPassword()
        )->setAccountNumber(
            $this->getAccountNumber()
        )->getOctopusGraphQL();

        return $this->connection;
    }
}
