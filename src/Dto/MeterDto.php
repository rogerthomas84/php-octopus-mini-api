<?php

namespace Rt\OctopusAPI\Dto;

/**
 * Class MeterDto
 * @package Rt\OctopusAPI\Dto
 */
class MeterDto
{
    /**
     * @var string
     */
    protected string $serialNumber;

    /**
     * @var MeterRegisterDto[]
     */
    protected array $registers;

    /**
     * @param array $data
     * @return MeterDto
     */
    public static function inflate(array $data): MeterDto
    {
        $meter = new self();
        $meter->serialNumber = $data['serial_number'];
        foreach ($data['registers'] as $register) {
            $meter->registers[] = MeterRegisterDto::inflate($register);
        }

        return $meter;
    }

    /**
     * @return string
     */
    public function getSerialNumber(): string
    {
        return $this->serialNumber;
    }

    /**
     * @return MeterRegisterDto[]
     */
    public function getRegisters(): array
    {
        return $this->registers;
    }
}
