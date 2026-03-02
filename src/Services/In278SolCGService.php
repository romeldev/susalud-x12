<?php

namespace Romeldev\SusaludX12\Services;

use Romeldev\SusaludX12\Beans\In278SolCG;
use Romeldev\SusaludX12\Converters\In278SolCGToBean;
use Romeldev\SusaludX12\Converters\In278SolCGToX12;
use Romeldev\SusaludX12\Services\Contracts\TransactionServiceInterface;

class In278SolCGService implements TransactionServiceInterface
{
    /**
     * Convierte un bean In278SolCG a trama X12.
     *
     * @param In278SolCG $bean
     * @return string
     */
    public function beanToX12($bean)
    {
        return In278SolCGToX12::traducirEstructura278Sol($bean);
    }

    /**
     * Convierte una trama X12 a bean In278SolCG.
     *
     * @param string $x12
     * @return In278SolCG
     */
    public function x12ToBean($x12)
    {
        return In278SolCGToBean::traducirEstructura278Sol($x12);
    }
}
