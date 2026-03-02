<?php

namespace Romeldev\SusaludX12\Services;

use Romeldev\SusaludX12\Beans\InRegAfi271;
use Romeldev\SusaludX12\Converters\RegAfi271ToBean;
use Romeldev\SusaludX12\Converters\RegAfi271ToX12;
use Romeldev\SusaludX12\Services\Contracts\TransactionServiceInterface;

class RegAfi271Service implements TransactionServiceInterface
{
    /**
     * Convierte un bean InRegAfi271 a trama X12.
     *
     * @param InRegAfi271 $bean
     * @return string
     */
    public function beanToX12($bean)
    {
        return RegAfi271ToX12::traducirEstructura271($bean);
    }

    /**
     * Convierte una trama X12 a bean InRegAfi271.
     *
     * @param string $x12
     * @return InRegAfi271
     */
    public function x12ToBean($x12)
    {
        return RegAfi271ToBean::traducirEstructura271($x12);
    }
}
