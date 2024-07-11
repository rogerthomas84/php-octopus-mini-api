<?php

namespace Rt\OctopusAPI\Dto;

/**
 * Class MeterRegisterDto
 * @package Rt\OctopusAPI\Dto
 */
class MeterRegisterDto implements InflatableDtoInterface
{
    /**
     * @var string
     */
    protected string $identifier;

    /**
     * @var string
     */
    protected string $rate;

    /**
     * @var bool
     */
    protected bool $isSettlementRegister;

    /**
     * @param array $data
     * @return MeterRegisterDto
     */
    public static function inflate(array $data): MeterRegisterDto
    {
        $meterRegister = new self();
        $meterRegister->identifier = $data['identifier'];
        $meterRegister->rate = $data['rate'];
        $meterRegister->isSettlementRegister = $data['is_settlement_register'];

        return $meterRegister;
    }

    /**
     * @return string
     */
    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    /**
     * @return string
     */
    public function getRate(): string
    {
        return $this->rate;
    }

    /**
     * @return bool
     */
    public function getIsSettlementRegister(): bool
    {
        return $this->isSettlementRegister;
    }
}
