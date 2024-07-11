<?php

namespace Rt\OctopusAPI\Dto;

use DateTime;
use Exception;

/**
 * Class PropertyDto
 * @package Rt\OctopusAPI\Dto
 */
class PropertyDto implements InflatableDtoInterface
{
    /**
     * @var int
     */
    protected int $id;

    /**
     * @var DateTime|null
     */
    protected DateTime|null $movedInAt;

    /**
     * @var DateTime|null
     */
    protected DateTime|null $movedOutAt;

    /**
     * @var string
     */
    protected string $addressLine1;

    /**
     * @var string
     */
    protected string $addressLine2;

    /**
     * @var string
     */
    protected string $addressLine3;

    /**
     * @var string
     */
    protected string $town;

    /**
     * @var string
     */
    protected string $county;

    /**
     * @var string
     */
    protected string $postcode;

    /**
     * @var array
     */
    protected array $electricityMeterPoints;

    /**
     * @todo this hasn't been implemented, because I don't use gas.
     * @var array
     */
    protected array $gasMeterPoints;

    /**
     * @param array $data
     * @return self
     * @throws Exception
     */
    public static function inflate(array $data): PropertyDto
    {
        $property = new self();
        $property->id = $data['id'];
        if ($data['moved_in_at'] !== null) {
            $data['moved_in_at'] = new DateTime($data['moved_in_at']);
        }
        $property->movedInAt = $data['moved_in_at'];
        if ($data['moved_out_at'] !== null) {
            $data['moved_out_at'] = new DateTime($data['moved_out_at']);
        }
        $property->movedOutAt = $data['moved_out_at'];
        $property->addressLine1 = $data['address_line_1'];
        $property->addressLine2 = $data['address_line_2'];
        $property->addressLine3 = $data['address_line_3'];
        $property->town = $data['town'];
        $property->county = $data['county'];
        $property->postcode = $data['postcode'];

        foreach ($data['electricity_meter_points'] as $electricityMeterPoint) {
            $property->electricityMeterPoints[] = ElectricityMeterPointDto::inflate($electricityMeterPoint);
        }

        $property->gasMeterPoints = $data['gas_meter_points'];

        return $property;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return DateTime|null
     */
    public function getMovedInAt(): ?DateTime
    {
        return $this->movedInAt;
    }

    /**
     * @return DateTime|null
     */
    public function getMovedOutAt(): ?DateTime
    {
        return $this->movedOutAt;
    }

    /**
     * @return string
     */
    public function getAddressLine1(): string
    {
        return $this->addressLine1;
    }

    /**
     * @return string
     */
    public function getAddressLine2(): string
    {
        return $this->addressLine2;
    }

    /**
     * @return string
     */
    public function getAddressLine3(): string
    {
        return $this->addressLine3;
    }

    /**
     * @return string
     */
    public function getTown(): string
    {
        return $this->town;
    }

    /**
     * @return string
     */
    public function getCounty(): string
    {
        return $this->county;
    }

    /**
     * @return string
     */
    public function getPostcode(): string
    {
        return $this->postcode;
    }

    /**
     * @return ElectricityMeterPointDto[]
     */
    public function getElectricityMeterPoints(): array
    {
        return $this->electricityMeterPoints;
    }

    /**
     * @return array
     * @todo this hasn't been implemented, because I don't use gas.
     */
    public function getGasMeterPoints(): array
    {
        return $this->gasMeterPoints;
    }
}
