<?php

namespace Rt\OctopusAPI\Dto\Traits;

/**
 * Trait PaymentMethodTrait
 * @package Rt\OctopusAPI\Dto\Traits
 */
trait PaymentMethodTrait
{
    /**
     * @var string|null
     */
    protected ?string $paymentMethod;

    /**
     * @return string|null
     */
    public function getPaymentMethod(): string|null
    {
        return $this->paymentMethod;
    }

    /**
     * @return bool
     */
    public function isDirectDebit(): bool
    {
        return 'DIRECT_DEBIT' === $this->getPaymentMethod();
    }

    /**
     * @return bool
     */
    public function isNonDirectDebit(): bool
    {
        return 'NON_DIRECT_DEBIT' === $this->getPaymentMethod();
    }
}
