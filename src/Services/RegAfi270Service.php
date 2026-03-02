<?php

namespace Romeldev\SusaludX12\Services;

use Romeldev\SusaludX12\Beans\InRegAfi270;
use Romeldev\SusaludX12\Converters\RegAfi270ToBean;
use Romeldev\SusaludX12\Converters\RegAfi270ToX12;
use Romeldev\SusaludX12\Services\Contracts\TransactionServiceInterface;

class RegAfi270Service implements TransactionServiceInterface
{
    /**
     * Convierte un bean InRegAfi270 a trama X12.
     *
     * @param InRegAfi270 $bean
     * @return string
     */
    public function beanToX12($bean)
    {
        return RegAfi270ToX12::traducirEstructura270($bean);
    }

    /**
     * Convierte una trama X12 a bean InRegAfi270.
     *
     * @param string $x12
     * @return InRegAfi270
     */
    public function x12ToBean($x12)
    {
        return RegAfi270ToBean::traducirEstructura270($x12);
    }
}
