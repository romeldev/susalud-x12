<?php

namespace Romeldev\SusaludX12\Services;

use Romeldev\SusaludX12\Beans\In271ResDeriva;
use Romeldev\SusaludX12\Converters\In271ResDerivaToBean;
use Romeldev\SusaludX12\Converters\In271ResDerivaToX12;
use Romeldev\SusaludX12\Services\Contracts\TransactionServiceInterface;

class In271ResDerivaService implements TransactionServiceInterface
{
    /**
     * Convierte un bean In271ResDeriva a trama X12.
     *
     * @param In271ResDeriva $bean
     * @return string
     */
    public function beanToX12($bean)
    {
        return In271ResDerivaToX12::traducirEstructura278ResDeriva($bean);
    }

    /**
     * Convierte una trama X12 a bean In271ResDeriva.
     *
     * @param string $x12
     * @return In271ResDeriva
     */
    public function x12ToBean($x12)
    {
        return In271ResDerivaToBean::traducirEstructura271ResDeriva($x12);
    }
}
