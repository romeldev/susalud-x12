<?php

namespace Romeldev\SusaludX12\Services;

use Romeldev\SusaludX12\Beans\InResEntVinc278;
use Romeldev\SusaludX12\Converters\ResEntVinc278ToBean;
use Romeldev\SusaludX12\Converters\ResEntVinc278ToX12;
use Romeldev\SusaludX12\Services\Contracts\TransactionServiceInterface;

class ResEntVinc278Service implements TransactionServiceInterface
{
    /**
     * Convierte un bean InResEntVinc278 a trama X12.
     *
     * @param InResEntVinc278 $bean
     * @return string
     */
    public function beanToX12($bean)
    {
        return ResEntVinc278ToX12::traducirEstructura271($bean);
    }

    /**
     * Convierte una trama X12 a bean InResEntVinc278.
     *
     * @param string $x12
     * @return InResEntVinc278
     */
    public function x12ToBean($x12)
    {
        return ResEntVinc278ToBean::traducirEstructura271($x12);
    }
}
