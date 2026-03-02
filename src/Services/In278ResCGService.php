<?php

namespace Romeldev\SusaludX12\Services;

use Romeldev\SusaludX12\Beans\In278ResCG;
use Romeldev\SusaludX12\Converters\In278ResCGToBean;
use Romeldev\SusaludX12\Converters\In278ResCGToX12;
use Romeldev\SusaludX12\Services\Contracts\TransactionServiceInterface;

class In278ResCGService implements TransactionServiceInterface
{
    /**
     * Convierte un bean In278ResCG a trama X12.
     *
     * @param In278ResCG $bean
     * @return string
     */
    public function beanToX12($bean)
    {
        return In278ResCGToX12::traducirEstructura278Res($bean);
    }

    /**
     * Convierte una trama X12 a bean In278ResCG.
     *
     * @param string $x12
     * @return In278ResCG
     */
    public function x12ToBean($x12)
    {
        return In278ResCGToBean::traducirEstructura278Res($x12);
    }
}
