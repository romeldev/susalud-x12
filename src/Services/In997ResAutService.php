<?php

namespace Romeldev\SusaludX12\Services;

use Romeldev\SusaludX12\Beans\In997ResAut;
use Romeldev\SusaludX12\Converters\In997ResAutToBean;
use Romeldev\SusaludX12\Converters\In997ResAutToX12;
use Romeldev\SusaludX12\Services\Contracts\TransactionServiceInterface;

class In997ResAutService implements TransactionServiceInterface
{
    /**
     * Convierte un bean In997ResAut a trama X12.
     *
     * @param In997ResAut $bean
     * @return string
     */
    public function beanToX12($bean)
    {
        return In997ResAutToX12::traducirEstructura997ResAut($bean);
    }

    /**
     * Convierte una trama X12 a bean In997ResAut.
     *
     * @param string $x12
     * @return In997ResAut
     */
    public function x12ToBean($x12)
    {
        return In997ResAutToBean::traducirEstructura997ResAut($x12);
    }
}
