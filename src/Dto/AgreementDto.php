<?php

namespace Rt\OctopusAPI\Dto;

use DateTime;
use Exception;

/**
 * Class AgreementDto
 * @package Rt\OctopusAPI\Dto
 */
class AgreementDto
{
    /**
     * @var string
     */
    protected string $tariffCode;

    /**
     * @var DateTime|null
     */
    protected DateTime|null $validFrom;

    /**
     * @var DateTime|null
     */
    protected DateTime|null $validTo;

    /**
     * @param array $data
     * @return AgreementDto
     * @throws Exception
     */
    public static function inflate(array $data): AgreementDto
    {
        $meter = new self();
        $meter->tariffCode = $data['tariff_code'];
        $meter->validFrom = null;
        $meter->validTo = null;
        if (null !== $data['valid_from']) {
            $meter->validFrom = new DateTime($data['valid_from']);
        }
        if (null !== $data['valid_to']) {
            $meter->validTo = new DateTime($data['valid_to']);
        }

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
     * @return DateTime|null
     */
    public function getValidFrom(): ?DateTime
    {
        return $this->validFrom;
    }

    /**
     * @return DateTime|null
     */
    public function getValidTo(): ?DateTime
    {
        return $this->validTo;
    }
}
