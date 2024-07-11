<?php

namespace Rt\OctopusAPI\Dto;

use DateTime;
use Exception;
use Rt\OctopusAPI\Dto\Traits\ValidDatesTrait;

/**
 * Class AgreementDto
 * @package Rt\OctopusAPI\Dto
 */
class AgreementDto implements InflatableDtoInterface
{
    use ValidDatesTrait;

    /**
     * @var string
     */
    protected string $tariffCode;

    /**
     * @param array $data
     * @return AgreementDto
     * @throws Exception
     */
    public static function inflate(array $data): AgreementDto
    {
        $meter = new self();
        $meter->tariffCode = $data['tariff_code'];
        $meter->populateValidFromValidTo($data);

        return $meter;
    }

    /**
     * @return string
     */
    public function getTariffCode(): string
    {
        return $this->tariffCode;
    }

    /**
     * @return string
     */
    public function getRegionCode(): string
    {
        $tariffCode = $this->getTariffCode();
        return trim(substr($tariffCode, 0, 2), '-');
    }

    /**
     * @return bool
     */
    public function isSingleRegister(): bool
    {
        $tariffCode = $this->getTariffCode();
        return str_starts_with($tariffCode, 'E-1R-');
    }

    /**
     * @return bool
     * @see self::isEconomySeven()
     */
    public function isDualRegister(): bool
    {
        return $this->isEconomySeven();
    }

    /**
     * @return bool
     */
    public function isEconomySeven(): bool
    {
        $tariffCode = $this->getTariffCode();
        return str_starts_with($tariffCode, 'E-2R-');
    }
}
