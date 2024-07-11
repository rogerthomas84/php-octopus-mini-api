<?php

namespace Rt\OctopusAPI\Dto\Traits;

/**
 * Trait ValueIncExVatTrait
 * @package Rt\OctopusAPI\Dto\Traits
 */
trait ValueIncExVatTrait
{
    /**
     * @var float
     */
    protected float $valueExcVat;

    /**
     * @var float
     */
    protected float $valueIncVat;

    /**
     * @return float
     */
    public function getValueExcVat(): float
    {
        return $this->valueExcVat;
    }

    /**
     * @return float
     */
    public function getValueIncVat(): float
    {
        return $this->valueIncVat;
    }
}
