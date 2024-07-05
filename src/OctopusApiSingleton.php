<?php

namespace Rt\OctopusAPI;

use GuzzleHttp\Exception\GuzzleException;

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
}
