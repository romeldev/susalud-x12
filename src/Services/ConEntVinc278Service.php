<?php

namespace Romeldev\SusaludX12\Services;

use Romeldev\SusaludX12\Beans\InConEntVinc278;
use Romeldev\SusaludX12\Converters\ConEntVinc278ToBean;
use Romeldev\SusaludX12\Converters\ConEntVinc278ToX12;
use Romeldev\SusaludX12\Services\Contracts\TransactionServiceInterface;

class ConEntVinc278Service implements TransactionServiceInterface
{
    /**
     * Convierte un bean InConEntVinc278 a trama X12.
     *
     * @param InConEntVinc278 $bean
     * @return string
     */
    public function beanToX12($bean)
    {
        return ConEntVinc278ToX12::traducirEstructura271($bean);
    }

    /**
     * Convierte una trama X12 a bean InConEntVinc278.
     *
     * @param string $x12
     * @return InConEntVinc278
     */
    public function x12ToBean($x12)
    {
        return ConEntVinc278ToBean::traducirEstructura271($x12);
    }
}
