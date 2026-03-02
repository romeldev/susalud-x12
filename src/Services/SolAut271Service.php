<?php

namespace Romeldev\SusaludX12\Services;

use Romeldev\SusaludX12\Beans\InSolAut271;
use Romeldev\SusaludX12\Converters\SolAut271ToBean;
use Romeldev\SusaludX12\Converters\SolAut271ToX12;
use Romeldev\SusaludX12\Services\Contracts\TransactionServiceInterface;

class SolAut271Service implements TransactionServiceInterface
{
    /**
     * Convierte un bean InSolAut271 a trama X12.
     *
     * @param InSolAut271 $bean
     * @return string
     */
    public function beanToX12($bean)
    {
        return SolAut271ToX12::traducirEstructura271($bean);
    }

    /**
     * Convierte una trama X12 a bean InSolAut271.
     *
     * @param string $x12
     * @return InSolAut271
     */
    public function x12ToBean($x12)
    {
        return SolAut271ToBean::traducirEstructura271($x12);
    }
}
