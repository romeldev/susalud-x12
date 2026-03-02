<?php

namespace Romeldev\SusaludX12\Services;

use Romeldev\SusaludX12\Beans\InConAse270;
use Romeldev\SusaludX12\Converters\ConAse270ToBean;
use Romeldev\SusaludX12\Converters\ConAse270ToX12;
use Romeldev\SusaludX12\Services\Contracts\TransactionServiceInterface;

class ConAse270Service implements TransactionServiceInterface
{
    /**
     * Convierte un bean InConAse270 a trama X12.
     *
     * @param InConAse270 $bean
     * @return string
     */
    public function beanToX12($bean)
    {
        return ConAse270ToX12::traducirEstructura270($bean);
    }

    /**
     * Convierte una trama X12 a bean InConAse270.
     *
     * @param string $x12
     * @return InConAse270
     */
    public function x12ToBean($x12)
    {
        return ConAse270ToBean::traducirEstructura270($x12);
    }
}
