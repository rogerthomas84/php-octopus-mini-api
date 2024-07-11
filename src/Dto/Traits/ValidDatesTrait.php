<?php

namespace Rt\OctopusAPI\Dto\Traits;

use DateTime;
use Exception;

/**
 * Trait ValidDatesTrait
 * @package Rt\OctopusAPI\Dto\Traits
 */
trait ValidDatesTrait
{
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
     * @return void
     * @throws Exception
     */
    protected function populateValidFromValidTo(array $data): void
    {
        $this->validFrom = null;
        $this->validTo = null;
        if (null !== $data['valid_from']) {
            $this->validFrom = new DateTime($data['valid_from']);
        }
        if (null !== $data['valid_to']) {
            $this->validTo = new DateTime($data['valid_to']);
        }
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

    /**
     * @param DateTime $date
     * @return bool
     */
    public function isValidForDateTime(DateTime $date): bool
    {
        if ($this->getValidFrom() === null || $this->getValidFrom() > $date) {
            return false;
        }

        if ($this->getValidTo() === null || $date <= $this->getValidTo()) {
            return true;
        }

        return false;
    }
}
