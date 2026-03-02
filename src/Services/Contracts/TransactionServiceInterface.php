<?php

namespace Romeldev\SusaludX12\Services\Contracts;

interface TransactionServiceInterface
{
    /**
     * Convierte un bean a trama X12.
     *
     * @param mixed $bean
     * @return string
     */
    public function beanToX12($bean);

    /**
     * Convierte una trama X12 a bean.
     *
     * @param string $x12
     * @return mixed
     */
    public function x12ToBean($x12);
}
