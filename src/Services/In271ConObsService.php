<?php

namespace Romeldev\SusaludX12\Services;

use Romeldev\SusaludX12\Beans\In271ConObs;
use Romeldev\SusaludX12\Converters\In271ConObsToBean;
use Romeldev\SusaludX12\Converters\In271ConObsToX12;
use Romeldev\SusaludX12\Services\Contracts\TransactionServiceInterface;

class In271ConObsService implements TransactionServiceInterface
{
    /**
     * Convierte un bean In271ConObs a trama X12.
     *
     * @param In271ConObs $bean
     * @return string
     */
    public function beanToX12($bean)
    {
        return In271ConObsToX12::traducirEstructura278ConObs($bean);
    }

    /**
     * Convierte una trama X12 a bean In271ConObs.
     *
     * @param string $x12
     * @return In271ConObs
     */
    public function x12ToBean($x12)
    {
        return In271ConObsToBean::traducirEstructura271ConObs($x12);
    }
}
