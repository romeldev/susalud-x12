<?php

namespace Romeldev\SusaludX12\Services;

use Romeldev\SusaludX12\Beans\InLogAcreInsert271;
use Romeldev\SusaludX12\Converters\LogAcreInsert271ToBean;
use Romeldev\SusaludX12\Converters\LogAcreInsert271ToX12;
use Romeldev\SusaludX12\Services\Contracts\TransactionServiceInterface;

class LogAcreInsert271Service implements TransactionServiceInterface
{
    /**
     * Convierte un bean InLogAcreInsert271 a trama X12.
     *
     * @param InLogAcreInsert271 $bean
     * @return string
     */
    public function beanToX12($bean)
    {
        return LogAcreInsert271ToX12::traducirEstructura271($bean);
    }

    /**
     * Convierte una trama X12 a bean InLogAcreInsert271.
     *
     * @param string $x12
     * @return InLogAcreInsert271
     */
    public function x12ToBean($x12)
    {
        return LogAcreInsert271ToBean::traducirEstructura271($x12);
    }
}
