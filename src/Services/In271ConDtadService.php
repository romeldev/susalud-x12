<?php

namespace Romeldev\SusaludX12\Services;

use Romeldev\SusaludX12\Beans\In271ConDtad;
use Romeldev\SusaludX12\Converters\In271ConDtadToBean;
use Romeldev\SusaludX12\Converters\In271ConDtadToX12;
use Romeldev\SusaludX12\Services\Contracts\TransactionServiceInterface;

class In271ConDtadService implements TransactionServiceInterface
{
    /**
     * Convierte un bean In271ConDtad a trama X12.
     *
     * @param In271ConDtad $bean
     * @return string
     */
    public function beanToX12($bean)
    {
        return In271ConDtadToX12::traducirEstructura278ConDtad($bean);
    }

    /**
     * Convierte una trama X12 a bean In271ConDtad.
     *
     * @param string $x12
     * @return In271ConDtad
     */
    public function x12ToBean($x12)
    {
        return In271ConDtadToBean::traducirEstructura278ConDtad($x12);
    }
}
