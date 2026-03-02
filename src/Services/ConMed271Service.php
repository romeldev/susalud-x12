<?php

namespace Romeldev\SusaludX12\Services;

use Romeldev\SusaludX12\Beans\InConMed271;
use Romeldev\SusaludX12\Converters\ConMed271ToBean;
use Romeldev\SusaludX12\Converters\ConMed271ToX12;
use Romeldev\SusaludX12\Services\Contracts\TransactionServiceInterface;

class ConMed271Service implements TransactionServiceInterface
{
    /**
     * Convierte un bean InConMed271 a trama X12.
     *
     * @param InConMed271 $bean
     * @return string
     */
    public function beanToX12($bean)
    {
        return ConMed271ToX12::traducirEstructura271($bean);
    }

    /**
     * Convierte una trama X12 a bean InConMed271.
     *
     * @param string $x12
     * @return InConMed271
     */
    public function x12ToBean($x12)
    {
        return ConMed271ToBean::traducirEstructura271($x12);
    }
}
