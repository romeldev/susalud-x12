<?php

namespace Romeldev\SusaludX12\Services;

use Romeldev\SusaludX12\Beans\InConNom271;
use Romeldev\SusaludX12\Converters\ConNom271ToBean;
use Romeldev\SusaludX12\Converters\ConNom271ToX12;
use Romeldev\SusaludX12\Services\Contracts\TransactionServiceInterface;

class ConNom271Service implements TransactionServiceInterface
{
    /**
     * Convierte un bean InConNom271 a trama X12.
     *
     * @param InConNom271 $bean
     * @return string
     */
    public function beanToX12($bean)
    {
        return ConNom271ToX12::traducirEstructura271($bean);
    }

    /**
     * Convierte una trama X12 a bean InConNom271.
     *
     * @param string $x12
     * @return InConNom271
     */
    public function x12ToBean($x12)
    {
        return ConNom271ToBean::traducirEstructura271($x12);
    }
}
