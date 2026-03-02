<?php

namespace Romeldev\SusaludX12\Services;

use Romeldev\SusaludX12\Beans\InConCod271;
use Romeldev\SusaludX12\Converters\ConCod271ToBean;
use Romeldev\SusaludX12\Converters\ConCod271ToX12;
use Romeldev\SusaludX12\Services\Contracts\TransactionServiceInterface;

class ConCod271Service implements TransactionServiceInterface
{
    /**
     * Convierte un bean InConCod271 a trama X12.
     *
     * @param InConCod271 $bean
     * @return string
     */
    public function beanToX12($bean)
    {
        return ConCod271ToX12::traducirEstructura271($bean);
    }

    /**
     * Convierte una trama X12 a bean InConCod271.
     *
     * @param string $x12
     * @return InConCod271
     */
    public function x12ToBean($x12)
    {
        return ConCod271ToBean::traducirEstructura271($x12);
    }
}
