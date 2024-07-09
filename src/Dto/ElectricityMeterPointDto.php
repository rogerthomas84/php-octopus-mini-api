<?php

namespace Rt\OctopusAPI\Dto;

use Exception;

/**
 * Class ElectricityMeterPointDto
 * @package Rt\OctopusAPI\Dto
 */
class ElectricityMeterPointDto
{
    /**
     * @var string
     */
    protected string $mpan;

    /**
     * @var int
     */
    protected int $profileClass;

    /**
     * @var int
     */
    protected int $consumptionStandard;

    /**
     * @var MeterDto[]
     */
    protected array $meters;

    /**
     * @var AgreementDto[]
     */
    protected array $agreements;

    /**
     * @var bool
     */
    protected bool $isExport;

    /**
     * @param array $data
     * @return ElectricityMeterPointDto
     * @throws Exception
     */
    public static function inflate(array $data): ElectricityMeterPointDto
    {
        $electricityMeterPoint = new self();
        $electricityMeterPoint->mpan = $data['mpan'];
        $electricityMeterPoint->profileClass = $data['profile_class'];
        $electricityMeterPoint->consumptionStandard = $data['consumption_standard'];
        $electricityMeterPoint->isExport = $data['is_export'];
        foreach ($data['meters'] as $meter) {
            $electricityMeterPoint->meters[] = MeterDto::inflate($meter);
        }
        foreach ($data['agreements'] as $agreement) {
            $electricityMeterPoint->agreements[] = AgreementDto::inflate($agreement);
        }

        return $electricityMeterPoint;
    }

    /**
     * @return string
     */
    public function getMpan(): string
    {
        return $this->mpan;
    }

    /**
     * @return int
     */
    public function getProfileClass(): int
    {
        return $this->profileClass;
    }

    /**
     * @return int
     */
    public function getConsumptionStandard(): int
    {
        return $this->consumptionStandard;
    }

    /**
     * @return MeterDto[]
     */
    public function getMeters(): array
    {
        return $this->meters;
    }

    /**
     * @return AgreementDto[]
     */
    public function getAgreements(): array
    {
        return $this->agreements;
    }

    /**
     * @return bool
     */
    public function isExport(): bool
    {
        return $this->isExport;
    }
}
