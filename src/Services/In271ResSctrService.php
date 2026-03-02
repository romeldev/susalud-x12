<?php

namespace Romeldev\SusaludX12\Services;

use Romeldev\SusaludX12\Beans\In271ResSctr;
use Romeldev\SusaludX12\Converters\In271ResSctrToBean;
use Romeldev\SusaludX12\Converters\In271ResSctrToX12;
use Romeldev\SusaludX12\Services\Contracts\TransactionServiceInterface;

class In271ResSctrService implements TransactionServiceInterface
{
    /**
     * Convierte un bean In271ResSctr a trama X12.
     *
     * @param In271ResSctr $bean
     * @return string
     */
    public function beanToX12($bean)
    {
        return In271ResSctrToX12::traducirEstructura271ResSctr($bean);
    }

    /**
     * Convierte una trama X12 a bean In271ResSctr.
     *
     * @param string $x12
     * @return In271ResSctr
     */
    public function x12ToBean($x12)
    {
        return In271ResSctrToBean::traducirEstructura271ResSctr($x12);
    }
}
