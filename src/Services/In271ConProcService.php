<?php

namespace Romeldev\SusaludX12\Services;

use Romeldev\SusaludX12\Beans\InConProc271;
use Romeldev\SusaludX12\Converters\In271ConProcToBean;
use Romeldev\SusaludX12\Converters\In271ConProcToX12;
use Romeldev\SusaludX12\Services\Contracts\TransactionServiceInterface;

class In271ConProcService implements TransactionServiceInterface
{
    /**
     * Convierte un bean InConProc271 a trama X12.
     *
     * @param InConProc271 $bean
     * @return string
     */
    public function beanToX12($bean)
    {
        return In271ConProcToX12::traducirEstructura278ConProc($bean);
    }

    /**
     * Convierte una trama X12 a bean InConProc271.
     *
     * @param string $x12
     * @return InConProc271
     */
    public function x12ToBean($x12)
    {
        return In271ConProcToBean::traducirEstructura271ConProc($x12);
    }
}
