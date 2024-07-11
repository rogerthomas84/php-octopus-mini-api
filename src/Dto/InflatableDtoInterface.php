<?php

namespace Rt\OctopusAPI\Dto;

use Exception;

/**
 * Interface InflatableDtoInterface
 * @package Rt\OctopusAPI\Dto
 */
interface InflatableDtoInterface
{
    /**
     * @param array $data
     * @return self
     * @throws Exception
     */
    public static function inflate(array $data): InflatableDtoInterface;
}
