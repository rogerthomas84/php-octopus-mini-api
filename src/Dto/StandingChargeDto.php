<?php

namespace Rt\OctopusAPI\Dto;

use Exception;
use Rt\OctopusAPI\Dto\Traits\PaymentMethodTrait;
use Rt\OctopusAPI\Dto\Traits\ValidDatesTrait;
use Rt\OctopusAPI\Dto\Traits\ValueIncExVatTrait;

/**
 * Class StandingChargeDto
 * @package Rt\OctopusAPI\Dto
 */
class StandingChargeDto implements InflatableDtoInterface
{
    use PaymentMethodTrait;
    use ValidDatesTrait;
    use ValueIncExVatTrait;

    /**
     * @param array $data
     * @return StandingChargeDto
     * @throws Exception
     */
    public static function inflate(array $data): StandingChargeDto
    {
        $charge = new self();
        $charge->valueExcVat = $data['value_exc_vat'];
        $charge->valueIncVat = $data['value_inc_vat'];
        $charge->paymentMethod = $data['payment_method'];
        $charge->populateValidFromValidTo($data);

        return $charge;
    }
}
