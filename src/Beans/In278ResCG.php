<?php

namespace Romeldev\SusaludX12\Beans;

use Romeldev\SusaludX12\Beans\Detalle\In278ResCGDetalle;

class In278ResCG extends AbstractBean
{
    /** @var string */
    protected $noTransaccion = '';
    /** @var string */
    protected $idRemitente = '';
    /** @var string */
    protected $idReceptor = '';
    /** @var string */
    protected $feTransaccion = '';
    /** @var string */
    protected $hoTransaccion = '';
    /** @var string */
    protected $idCorrelativo = '';
    /** @var string */
    protected $idTransaccion = '';
    /** @var string */
    protected $tiFinalidad = '';
    /** @var string */
    protected $caRemitente = '';
    /** @var string */
    protected $caReceptor = '';
    /** @var string */
    protected $nuRucReceptor = '';
    /** @var string */
    protected $nuControl = '';
    /** @var string */
    protected $nuControlST = '';
    /** @var In278ResCGDetalle[] */
    protected $in278ResCGDetalles = [];

    /** @inheritdoc */
    protected function getPropertyAliases()
    {
        return [
            'detalles' => 'in278ResCGDetalles',
        ];
    }
}
