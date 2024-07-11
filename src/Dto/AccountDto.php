<?php

namespace Rt\OctopusAPI\Dto;

use Exception;

/**
 * Class AccountDto
 * @package Rt\OctopusAPI\Dto
 */
class AccountDto implements InflatableDtoInterface
{
    /**
     * @var string
     */
    protected string $number;

    /**
     * @var PropertyDto[]
     */
    protected array $properties;

    /**
     * @param array $data
     * @return self
     * @throws Exception
     */
    public static function inflate(array $data): AccountDto
    {
        $account = new self();
        $account->number = $data['number'];
        foreach ($data['properties'] as $property) {
            $account->properties[] = PropertyDto::inflate($property);
        }

        return $account;
    }

    /**
     * @return string
     */
    public function getNumber(): string
    {
        return $this->number;
    }

    /**
     * @return PropertyDto[]
     */
    public function getProperties(): array
    {
        return $this->properties;
    }
}
